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
        Schema::table('user_cvs', function (Blueprint $table) {
            if (!Schema::hasColumn('user_cvs', 'github_url')) {
                $table->string('github_url')->nullable()->after('website_url');
            }
            if (!Schema::hasColumn('user_cvs', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable()->after('github_url');
            }
        });

        Schema::create('cv_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_projects');
        Schema::table('user_cvs', function (Blueprint $table) {
            $table->dropColumn(['github_url', 'linkedin_url']);
        });
    }
};
