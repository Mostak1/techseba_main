<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('preview_image')->nullable();
            $table->string('view_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('user_cvs', function (Blueprint $table) {
            $table->foreignId('portfolio_template_id')
                ->nullable()
                ->after('template_id')
                ->constrained('portfolio_templates')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('portfolio_template_id');
        });

        Schema::dropIfExists('portfolio_templates');
    }
};
