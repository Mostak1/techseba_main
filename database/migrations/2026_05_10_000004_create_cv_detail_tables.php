<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('responsibilities')->nullable();
            $table->text('achievements')->nullable();
            $table->string('company_location')->nullable();
            $table->string('business_type')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('degree_name')->nullable();
            $table->string('institution')->nullable();
            $table->string('board_or_university')->nullable();
            $table->string('group_or_major')->nullable();
            $table->string('result')->nullable();
            $table->string('passing_year')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('training_title')->nullable();
            $table->string('institute')->nullable();
            $table->string('duration')->nullable();
            $table->string('year')->nullable();
            $table->text('certificate_details')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_professional_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('authority')->nullable();
            $table->string('result_or_score')->nullable();
            $table->string('year')->nullable();
            $table->text('details')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('skill_type')->nullable();
            $table->string('skill_name')->nullable();
            $table->string('skill_level')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('language_name')->nullable();
            $table->string('reading_level')->nullable();
            $table->string('writing_level')->nullable();
            $table->string('speaking_level')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_cv_id')->constrained('user_cvs')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('organization')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('relationship')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_references');
        Schema::dropIfExists('cv_languages');
        Schema::dropIfExists('cv_skills');
        Schema::dropIfExists('cv_professional_qualifications');
        Schema::dropIfExists('cv_trainings');
        Schema::dropIfExists('cv_academics');
        Schema::dropIfExists('cv_employments');
    }
};
