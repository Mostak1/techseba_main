<?php

namespace App\Services;

use App\Models\CvTemplate;
use App\Models\PortfolioTemplate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Central, whitelisted registry for CV & Portfolio templates.
 *
 * - Templates are only ever resolved from DB metadata (never from request input).
 * - Blade view paths are validated against an allowed prefix list and checked for existence.
 * - Missing / inactive / broken templates fall back to a safe default and are logged.
 */
class TemplateRegistry
{
    public const TYPES = [
        'cv' => CvTemplate::class,
        'portfolio' => PortfolioTemplate::class,
    ];

    public const FOREIGN_KEYS = [
        'cv' => 'template_id',
        'portfolio' => 'portfolio_template_id',
    ];

    public const DEFAULT_VIEWS = [
        'cv' => 'frontend.cv.templates.bdjobs',
        'portfolio' => 'frontend.cv.portfolio',
    ];

    /** Only views under these namespaces may ever be rendered as a template. */
    public const ALLOWED_VIEW_PREFIXES = [
        'frontend.cv.',
        'cv.templates.',
        'portfolio.templates.',
    ];

    /** Columns needed by the gallery (avoid loading heavy/unneeded data). */
    private const GALLERY_COLUMNS = [
        'id', 'name', 'slug', 'description', 'preview_image',
        'category', 'style', 'is_premium', 'sort_order',
    ];

    public function isValidType(string $type): bool
    {
        return array_key_exists($type, self::TYPES);
    }

    /** @return class-string<Model> */
    public function modelClass(string $type): string
    {
        abort_unless($this->isValidType($type), 404);

        return self::TYPES[$type];
    }

    public function activeQuery(string $type): Builder
    {
        $class = $this->modelClass($type);

        return $class::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function paginateGallery(string $type, ?string $search, ?string $category, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->activeQuery($type)->select(self::GALLERY_COLUMNS);

        if ($search = trim((string) $search)) {
            $like = '%'.addcslashes($search, '%_\\').'%';
            $query->where(function (Builder $q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhere('category', 'like', $like)
                    ->orWhere('style', 'like', $like);
            });
        }

        if ($category && strtolower($category) !== 'all') {
            $query->where('category', $category);
        }

        return $query->paginate(max(1, min($perPage, 48)));
    }

    /** Distinct categories of active templates (for filter chips). */
    public function categories(string $type): array
    {
        return $this->activeQuery($type)
            ->reorder()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->all();
    }

    public function findActiveBySlug(string $type, string $slug): ?Model
    {
        return $this->activeQuery($type)->where('slug', $slug)->first();
    }

    public function findActiveById(string $type, int $id): ?Model
    {
        return $this->activeQuery($type)->whereKey($id)->first();
    }

    /**
     * Returns the template that will effectively be used: the given one if it is active
     * and renderable, otherwise the default/first active template.
     */
    public function effectiveTemplate(string $type, ?Model $template): ?Model
    {
        if ($template && $template->is_active && $this->isRenderableView($template->view_path)) {
            return $template;
        }

        $active = $this->activeQuery($type)->get();

        return $active->first(fn ($t) => $t->view_path === self::DEFAULT_VIEWS[$type] && $this->isRenderableView($t->view_path))
            ?? $active->first(fn ($t) => $this->isRenderableView($t->view_path));
    }

    /**
     * Resolve a safe Blade view name for a template model. Never accepts raw request input.
     */
    public function resolveView(string $type, ?Model $template, array $context = []): string
    {
        $default = self::DEFAULT_VIEWS[$type] ?? self::DEFAULT_VIEWS['cv'];

        if (! $template) {
            return $default;
        }

        if (! $template->is_active) {
            Log::warning('Inactive template requested, falling back to default.', $context + [
                'type' => $type, 'template_id' => $template->id, 'slug' => $template->slug,
            ]);

            return $default;
        }

        if (! $this->isRenderableView($template->view_path)) {
            Log::error('Template view missing or not whitelisted, falling back to default.', $context + [
                'type' => $type, 'template_id' => $template->id, 'view_path' => $template->view_path,
            ]);

            return $default;
        }

        return $template->view_path;
    }

    public function isRenderableView(?string $viewPath): bool
    {
        if (! $viewPath || ! preg_match('/^[A-Za-z0-9_.\-]+$/', $viewPath)) {
            return false;
        }

        $allowed = false;
        foreach (self::ALLOWED_VIEW_PREFIXES as $prefix) {
            if (str_starts_with($viewPath, $prefix)) {
                $allowed = true;
                break;
            }
        }

        return $allowed && view()->exists($viewPath);
    }
}
