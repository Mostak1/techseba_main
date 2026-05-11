<?php

namespace Database\Seeders;

use App\Models\PortfolioTemplate;
use Illuminate\Database\Seeder;

class PortfolioTemplateSeeder extends Seeder
{
    public function run(): void
    {
        PortfolioTemplate::updateOrCreate(
            ['slug' => 'modern'],
            [
                'name' => 'Modern Portfolio',
                'preview_image' => null,
                'view_path' => 'frontend.cv.portfolio',
                'is_active' => true,
            ]
        );

        PortfolioTemplate::updateOrCreate(
            ['slug' => 'classic'],
            [
                'name' => 'Classic Portfolio',
                'preview_image' => null,
                'view_path' => 'frontend.cv.portfolio_classic',
                'is_active' => true,
            ]
        );
    }
}
