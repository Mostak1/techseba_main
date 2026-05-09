<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('global_settings')->insert([
            ['key' => 'pixel_access_token', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'pixel_test_code', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('global_settings')->whereIn('key', ['pixel_access_token', 'pixel_test_code'])->delete();
    }
};
