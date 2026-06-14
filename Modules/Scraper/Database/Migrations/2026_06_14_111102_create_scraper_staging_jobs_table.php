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
        Schema::create('scraper_staging_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scraper_source_id')->constrained('scraper_sources')->onDelete('cascade');
            $table->string('title');
            $table->string('organization_name')->nullable();
            $table->string('category_name')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();
            $table->string('experience_level')->nullable();
            $table->longText('description');
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->foreignId('approved_job_post_id')->nullable()->constrained('job_posts')->onDelete('set null');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraper_staging_jobs');
    }
};
