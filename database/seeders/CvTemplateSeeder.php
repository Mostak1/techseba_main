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
            [
                'slug' => 'creative',
                'name' => 'Creative Executive',
                'description' => 'High-impact executive layout with indigo gradient sidebar, skill pills, and timeline milestones.',
                'category' => 'Creative',
                'style' => 'Indigo Gradient Sidebar',
                'view_path' => 'frontend.cv.templates.creative',
                'preview_image' => 'uploads/website-images/templates/creative.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'cv-it',
                'name' => 'CV IT & Software',
                'description' => 'Clean professional 2-column IT & Software Engineering resume layout designed for maximum interview callbacks.',
                'category' => 'IT & Software',
                'style' => 'Navy Dual-Column Professional',
                'view_path' => 'frontend.cv.templates.cv_it',
                'preview_image' => 'uploads/website-images/templates/cv_it.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($templates as $t) {
            CvTemplate::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
