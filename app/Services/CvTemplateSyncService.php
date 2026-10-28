<?php

namespace App\Services;

use App\Models\CvTemplate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CvTemplateSyncService
{
    public const JSON_PATH = 'database/data/cv_templates.json';

    /**
     * Synchronize templates from JSON file into the database.
     */
    public function syncFromJson(): array
    {
        $filePath = base_path(self::JSON_PATH);

        if (! File::exists($filePath)) {
            return [
                'success' => false,
                'message' => 'JSON template file not found at ' . self::JSON_PATH,
                'count' => 0,
            ];
        }

        $jsonContent = File::get($filePath);
        $templates = json_decode($jsonContent, true);

        if (! is_array($templates)) {
            return [
                'success' => false,
                'message' => 'Invalid JSON structure in ' . self::JSON_PATH,
                'count' => 0,
            ];
        }

        $syncedCount = 0;

        foreach ($templates as $item) {
            if (empty($item['path'])) {
                continue;
            }

            $slug = $item['slug'] ?? \Illuminate\Support\Str::slug($item['title'] ?? 'template-' . ($item['id'] ?? uniqid()));
            $id = ! empty($item['id']) ? (int) $item['id'] : null;

            // 1. Match by unique slug first so we never trigger unique key constraint collisions
            $template = CvTemplate::where('slug', $slug)->first();

            // 2. If not found by slug, check by ID
            if (! $template && $id) {
                $template = CvTemplate::find($id);
            }

            // 3. If still not found, create new instance
            if (! $template) {
                $template = new CvTemplate();
                if ($id && ! CvTemplate::whereKey($id)->exists()) {
                    $template->id = $id;
                }
            }

            // 4. Update attributes safely
            $template->name = $item['title'] ?? ($item['name'] ?? 'Template #' . ($id ?? $slug));
            $template->slug = $slug;
            $template->view_path = $item['path'];
            $template->category = $item['category'] ?? 'Modern';
            $template->style = $item['style'] ?? 'Clean';
            $template->description = $item['description'] ?? null;
            $template->preview_image = $item['preview_image'] ?? null;
            $template->is_premium = (bool) ($item['is_paid'] ?? ($item['is_premium'] ?? false));
            $template->is_active = (bool) ($item['is_active'] ?? true);
            $template->save();

            $syncedCount++;
        }

        return [
            'success' => true,
            'message' => "Successfully synchronized {$syncedCount} templates from JSON.",
            'count' => $syncedCount,
        ];
    }

    /**
     * Export all database templates into the JSON file.
     */
    public function exportToJson(): array
    {
        $templates = CvTemplate::orderBy('id')->get()->map(function ($t) {
            return [
                'id' => $t->id,
                'title' => $t->name,
                'slug' => $t->slug,
                'blade_name' => basename(str_replace('.', '/', $t->view_path)) . '.blade.php',
                'path' => $t->view_path,
                'category' => $t->category ?: 'Modern',
                'style' => $t->style ?: 'Standard',
                'description' => $t->description ?: '',
                'preview_image' => $t->preview_image ?: '',
                'is_paid' => (bool) $t->is_premium,
                'is_active' => (bool) $t->is_active,
            ];
        })->toArray();

        $filePath = base_path(self::JSON_PATH);
        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, json_encode($templates, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return [
            'success' => true,
            'message' => 'Successfully exported templates to JSON.',
            'count' => count($templates),
        ];
    }
}
