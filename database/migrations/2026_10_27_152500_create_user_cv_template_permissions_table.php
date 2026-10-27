<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_cv_template_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cv_template_id')->constrained('cv_templates')->onDelete('cascade');
            $table->enum('status', ['active', 'pending', 'rejected'])->default('active')->index();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'cv_template_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cv_template_permissions');
    }
};
