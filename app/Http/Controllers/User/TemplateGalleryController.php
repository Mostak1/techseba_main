<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserCv;
use App\Services\CvPreviewDataService;
use App\Services\TemplateRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Template gallery + live preview engine for CV and Portfolio templates.
 *
 * The {type} ("cv" | "portfolio") is injected through route defaults, never through user input.
 */
class TemplateGalleryController extends Controller
{
    public function __construct(
        private readonly TemplateRegistry $registry,
        private readonly CvPreviewDataService $previewData,
    ) {}

    /**
     * GET /user/cv/templates  |  GET /user/portfolio/templates
     * Paginated, searchable, filterable gallery (JSON with rendered card HTML).
     */
    public function index(Request $request, string $type): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:60'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:48'],
        ]);

        $paginator = $this->registry->paginateGallery(
            $type,
            $validated['search'] ?? null,
            $validated['category'] ?? null,
            (int) ($validated['per_page'] ?? 12),
        );

        $cv = $this->currentCv();
        $selectedId = $this->selectedTemplateId($type, $cv);

        $html = '';
        foreach ($paginator->items() as $template) {
            $html .= view('user.cv.partials.template-card', [
                'template' => $template,
                'type' => $type,
                'selected' => (int) $template->id === (int) $selectedId,
            ])->render();
        }

        return response()->json([
            'success' => true,
            'data' => collect($paginator->items())->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
                'description' => $t->description,
                'category' => $t->category,
                'style' => $t->style,
                'is_premium' => (bool) $t->is_premium,
                'thumbnail' => $t->thumbnail_url,
                'preview_url' => $this->previewUrl($type, $t->slug),
                'selected' => (int) $t->id === (int) $selectedId,
            ])->values(),
            'html' => $html,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'has_more' => $paginator->hasMorePages(),
            ],
        ]);
    }

    /**
     * GET /user/cv/templates/{slug}/preview
     * Preview shell page (toolbar + device frame). Does NOT change the user's selection.
     */
    public function preview(string $type, string $slug)
    {
        $template = $this->registry->findActiveBySlug($type, $slug);
        abort_unless($template, 404);

        $cv = $this->currentCv();

        return view('user.cv.template-preview', [
            'template' => $template,
            'type' => $type,
            'renderUrl' => profile_route($this->routeName($type, 'render'), ['slug' => $template->slug]),
            'selectUrl' => profile_route($this->routeName($type, 'select')),
            'isSelected' => (int) $this->selectedTemplateId($type, $cv) === (int) $template->id,
            'settingsUrl' => profile_route('user.cv.edit', ['tab' => 'settings']),
        ]);
    }

    /**
     * GET /user/cv/templates/{slug}/render
     * Renders the whitelisted Blade view with the centralized DUMMY dataset (inside the preview iframe).
     */
    public function render(string $type, string $slug)
    {
        $template = $this->registry->findActiveBySlug($type, $slug);
        abort_unless($template, 404);

        $view = $this->registry->resolveView($type, $template, ['context' => 'gallery-preview']);
        $demoCv = $this->previewData->make();

        $data = [
            'cv' => $demoCv,
            'username' => CvPreviewDataService::DEMO_USERNAME,
            'isTemplatePreview' => true,
            'showActions' => false,
            'printEnabled' => false,
            'pdfEnabled' => false,
            'printUrl' => null,
            'pdfUrl' => null,
            'cvUrl' => null,
            'printMode' => false,
            'forPdf' => false,
        ];

        try {
            return response()
                ->view($view, $data)
                ->header('X-Robots-Tag', 'noindex, nofollow');
        } catch (\Throwable $e) {
            Log::error('Template preview render failed.', [
                'type' => $type, 'slug' => $slug, 'view' => $view, 'error' => $e->getMessage(),
            ]);

            $fallback = TemplateRegistry::DEFAULT_VIEWS[$type];
            abort_if($fallback === $view, 500, 'Template preview is temporarily unavailable.');

            return response()->view($fallback, $data);
        }
    }

    /**
     * POST /user/cv/templates/select  { template_id }
     */
    public function select(Request $request, string $type): JsonResponse
    {
        $validated = $request->validate([
            'template_id' => ['required', 'integer', 'min:1'],
        ]);

        $template = $this->registry->findActiveById($type, (int) $validated['template_id']);

        if (! $template || ! $this->registry->isRenderableView($template->view_path)) {
            return response()->json([
                'success' => false,
                'message' => 'This template is not available.',
            ], 422);
        }

        $cv = $this->currentCv(createIfMissing: true);
        $cv->{TemplateRegistry::FOREIGN_KEYS[$type]} = $template->id;
        $cv->save();

        return response()->json([
            'success' => true,
            'message' => $type === 'cv' ? 'CV template selected successfully.' : 'Portfolio template selected successfully.',
            'template' => [
                'id' => $template->id,
                'name' => $template->name,
                'slug' => $template->slug,
            ],
        ]);
    }

    private function currentCv(bool $createIfMissing = false): ?UserCv
    {
        $user = Auth::guard('web')->user();
        $cv = $user->userCv()->with(['template', 'portfolioTemplate'])->first();

        if (! $cv && $createIfMissing) {
            $default = $this->registry->effectiveTemplate('cv', null);
            $cv = UserCv::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->phone ?? '',
                'template_id' => $default?->id ?? 1,
            ]);
        }

        return $cv;
    }

    /** The template the user effectively uses (respects fallback for inactive/missing templates). */
    private function selectedTemplateId(string $type, ?UserCv $cv): ?int
    {
        $current = $type === 'cv' ? $cv?->template : $cv?->portfolioTemplate;

        return $this->registry->effectiveTemplate($type, $current)?->id;
    }

    private function routeName(string $type, string $action): string
    {
        return $type === 'cv' ? "user.cv.templates.$action" : "user.cv.portfolio-templates.$action";
    }

    private function previewUrl(string $type, string $slug): string
    {
        return profile_route($this->routeName($type, 'preview'), ['slug' => $slug]);
    }
}
