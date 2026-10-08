<?php

namespace Database\Seeders;

use App\Models\PortfolioTemplate;
use Illuminate\Database\Seeder;

class PortfolioTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'slug' => 'modern',
                'name' => 'Modern Portfolio',
                'description' => 'Full-featured web portfolio with interactive project cards, technical metrics, and skill breakdowns.',
                'category' => 'Modern',
                'style' => 'Interactive Showcase',
                'view_path' => 'frontend.cv.portfolio',
                'preview_image' => 'uploads/website-images/templates/portfolio_modern.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'classic',
                'name' => 'Classic Portfolio',
                'description' => 'Clean, elegant layout focusing on experience timeline, core achievements, and contact information.',
                'category' => 'Minimal',
                'style' => 'Clean Single-Page',
                'view_path' => 'frontend.cv.portfolio_classic',
                'preview_image' => 'uploads/website-images/templates/portfolio_classic.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'application',
                'name' => 'Application Portfolio',
                'description' => 'App-dashboard styled portfolio featuring dark aesthetic, project metrics, and rating breakdowns.',
                'category' => 'Professional',
                'style' => 'App Dashboard Layout',
                'view_path' => 'frontend.cv.portfolio_application',
                'preview_image' => 'uploads/website-images/templates/portfolio_application.webp',
                'is_premium' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($templates as $t) {
            PortfolioTemplate::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
