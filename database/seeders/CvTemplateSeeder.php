<?php

namespace Database\Seeders;

use App\Models\CvTemplate;
use Illuminate\Database\Seeder;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        CvTemplate::updateOrCreate(
            ['slug' => 'bdjobs'],
            [
                'name' => 'BD Jobs Style',
                'preview_image' => null,
                'view_path' => 'frontend.cv.templates.bdjobs',
                'is_active' => true,
            ]
        );
    }
}
