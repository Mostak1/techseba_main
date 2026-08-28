<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            $table->text('technical_challenge')->nullable()->after('career_summary');
            $table->text('built_from_scratch')->nullable()->after('technical_challenge');
            $table->json('proficiency_ratings')->nullable()->after('built_from_scratch');
            $table->text('sparks_joy')->nullable()->after('proficiency_ratings');
            $table->string('landing_page_url')->nullable()->after('sparks_joy');
        });
    }

    public function down(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            $table->dropColumn([
                'technical_challenge',
                'built_from_scratch',
                'proficiency_ratings',
                'sparks_joy',
                'landing_page_url',
            ]);
        });
    }
};
