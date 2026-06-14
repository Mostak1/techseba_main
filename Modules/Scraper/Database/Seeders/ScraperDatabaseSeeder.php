<?php

namespace Modules\Scraper\Database\Seeders;

use Illuminate\Database\Seeder;

class ScraperDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Modules\Scraper\App\Models\ScraperSource::create([
            'name' => 'Bangladesh Government Jobs Portal',
            'url' => 'http://bpsc.teletalk.com.bd',
            'type' => 'css',
            'selectors' => [
                'list' => '//div[contains(@class, "job-item")]',
                'title' => './/h3',
                'description' => './/div[contains(@class, "desc")]',
            ],
            'status' => true,
        ]);
        
        \Modules\Scraper\App\Models\ScraperSource::create([
            'name' => 'Ministry of Primary and Mass Education',
            'url' => 'https://mopme.gov.bd',
            'type' => 'css',
            'selectors' => [
                'list' => '//table//tr',
                'title' => './/td[2]',
                'description' => './/td[3]',
            ],
            'status' => true,
        ]);
    }
}
