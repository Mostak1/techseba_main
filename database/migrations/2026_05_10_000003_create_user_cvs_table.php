<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_cvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('cv_templates')->nullOnDelete();
            $table->string('full_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('nid_or_passport')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->string('photo')->nullable();
            $table->text('career_objective')->nullable();
            $table->text('career_summary')->nullable();
            $table->decimal('total_experience', 5, 2)->nullable();
            $table->text('declaration')->nullable();
            $table->string('signature')->nullable();
            $table->date('declaration_date')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('public_print_enabled')->default(false);
            $table->boolean('public_pdf_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cvs');
    }
};
