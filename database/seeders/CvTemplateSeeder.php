<?php

namespace Database\Seeders;

use App\Models\CvTemplate;
use Illuminate\Database\Seeder;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'slug' => 'bdjobs',
                'name' => 'BD Jobs Standard',
                'description' => 'Standard corporate resume format designed for corporate and enterprise job applications.',
                'category' => 'Corporate',
                'style' => 'Clean & Standard',
                'view_path' => 'frontend.cv.templates.bdjobs',
                'preview_image' => 'uploads/website-images/templates/bdjobs.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'modern',
                'name' => 'Modern Professional',
                'description' => 'Sleek modern layout featuring dual columns, styled badges, and high readability.',
                'category' => 'Modern',
                'style' => 'Two-Column Accent',
                'view_path' => 'frontend.cv.templates.modern',
                'preview_image' => 'uploads/website-images/templates/modern.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($templates as $t) {
            CvTemplate::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
