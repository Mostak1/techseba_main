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
        Schema::table('job_posts', function (Blueprint $table) {
            $table->fullText(['title', 'location'], 'job_posts_title_location_fulltext');
        });

        Schema::table('job_details', function (Blueprint $table) {
            $table->fullText(['description', 'requirements', 'responsibilities'], 'job_details_content_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropIndex('job_posts_title_location_fulltext');
        });

        Schema::table('job_details', function (Blueprint $table) {
            $table->dropIndex('job_details_content_fulltext');
        });
    }
};
