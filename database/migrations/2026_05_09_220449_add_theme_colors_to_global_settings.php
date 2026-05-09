<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $colors = [
            'theme_heading_color' => '#0a165e',
            'theme_body_color' => '#585b6f',
            'theme_accent_color' => '#2b4dff',
            'theme_white_color' => '#ffffff',
            'theme_light_color1' => '#e3e3ec',
            'theme_light_color2' => '#ced0df',
            'theme_dark_bg' => '#040d43',
            'theme_dark_bg2' => '#1e2656',
            'theme_dark_bg3' => '#0a165e',
            'theme_white_bg' => '#ffffff',
            'theme_accent_bg' => '#2b4dff',
            'theme_light_bg1' => '#f5f6f7',
            'theme_light_bg2' => '#e2e3ec',
            'theme_light_bg3' => '#eef1ff',
        ];

        foreach ($colors as $key => $value) {
            \DB::table('global_settings')->insertOrIgnore([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'theme_heading_color',
            'theme_body_color',
            'theme_accent_color',
            'theme_white_color',
            'theme_light_color1',
            'theme_light_color2',
            'theme_dark_bg',
            'theme_dark_bg2',
            'theme_dark_bg3',
            'theme_white_bg',
            'theme_accent_bg',
            'theme_light_bg1',
            'theme_light_bg2',
            'theme_light_bg3',
        ];

        \DB::table('global_settings')->whereIn('key', $keys)->delete();
    }
};
