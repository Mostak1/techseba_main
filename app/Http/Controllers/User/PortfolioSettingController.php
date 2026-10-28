<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PortfolioTemplate;
use App\Models\ProfileDomain;
use App\Models\UserCv;
use App\Services\TemplateRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioSettingController extends Controller
{
    public function __construct(
        private readonly TemplateRegistry $registry
    ) {}

    /**
     * Display Portfolio & Domain UI Settings page.
     */
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();

        $cv = $user->userCv()->with(['template', 'portfolioTemplate'])->first();
        if (! $cv) {
            $defaultTpl = $this->registry->effectiveTemplate('cv', null);
            $defaultPort = $this->registry->effectiveTemplate('portfolio', null);
            $cv = UserCv::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->phone ?? '',
                'template_id' => $defaultTpl?->id ?? 1,
                'portfolio_template_id' => $defaultPort?->id ?? 1,
                'is_public' => true,
                'public_print_enabled' => true,
            ]);
            $cv->load(['template', 'portfolioTemplate']);
        }

        $portfolioTemplates = $this->registry->activeQuery('portfolio')->get();
        $selectedPortfolioTemplate = $this->registry->effectiveTemplate('portfolio', $cv->portfolioTemplate);
        $portfolioCategories = $this->registry->categories('portfolio');

        $baseDomain = ProfileDomain::getBaseDomain();
        $subdomain = $user->profileDomains()->where('type', 'subdomain')->first();
        $customDomains = $user->profileDomains()->where('type', 'custom_domain')->latest()->get();
        $primaryDomain = $user->profileDomains()->where('is_primary', true)->first();

        // Visitor URLs
        $mainPortfolioUrl = url('/' . ($user->username ?: $user->id));
        $cvUrl = route('cv.public', $user->username ?: $user->id);
        $subdomainUrl = $subdomain ? $subdomain->url : null;
        $primaryDomainUrl = $primaryDomain ? $primaryDomain->url : ($subdomainUrl ?: $mainPortfolioUrl);

        return view('user.portfolio_settings', compact(
            'user',
            'cv',
            'portfolioTemplates',
            'selectedPortfolioTemplate',
            'portfolioCategories',
            'baseDomain',
            'subdomain',
            'customDomains',
            'primaryDomain',
            'mainPortfolioUrl',
            'cvUrl',
            'subdomainUrl',
            'primaryDomainUrl'
        ));
    }

    /**
     * Select active portfolio template.
     */
    public function selectTemplate(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'template_id' => ['required', 'integer', 'exists:portfolio_templates,id'],
        ]);

        $template = $this->registry->findActiveById('portfolio', (int) $validated['template_id']);

        if (! $template || ! $this->registry->isRenderableView($template->view_path)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected portfolio template is currently not available.',
                ], 422);
            }

            $notify_message = trans('translate.The selected portfolio template is currently not available.');
            $notify_message = ['message' => $notify_message, 'alert-type' => 'error'];
            return redirect()->back()->with($notify_message);
        }

        $user = Auth::guard('web')->user();
        $cv = $user->userCv()->first();
        if (! $cv) {
            $cv = UserCv::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->phone ?? '',
                'template_id' => 1,
                'portfolio_template_id' => $template->id,
                'is_public' => true,
            ]);
        } else {
            $cv->portfolio_template_id = $template->id;
            $cv->save();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Portfolio design successfully switched to '{$template->name}'.",
                'template' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'slug' => $template->slug,
                    'style' => $template->style,
                    'category' => $template->category,
                ],
            ]);
        }

        $notify_message = trans("Portfolio design successfully switched to '{$template->name}'.");
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }

    /**
     * Update portfolio display settings (e.g., visibility, print buttons).
     */
    public function updateVisibility(Request $request): JsonResponse|RedirectResponse
    {
        $user = Auth::guard('web')->user();
        $cv = $user->userCv()->firstOrFail();

        if ($request->has('is_public')) {
            $cv->is_public = $request->boolean('is_public');
        }
        if ($request->has('public_print_enabled')) {
            $cv->public_print_enabled = $request->boolean('public_print_enabled');
        }
        $cv->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Portfolio visibility settings updated successfully.',
            ]);
        }

        $notify_message = trans('Portfolio settings updated successfully.');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];

        return redirect()->back()->with($notify_message);
    }
}
