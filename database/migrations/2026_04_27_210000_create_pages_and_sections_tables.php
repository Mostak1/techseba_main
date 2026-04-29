<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('section_name');
            $table->string('section_identifier');
            $table->enum('status', ['enable', 'disable'])->default('enable');
            $table->timestamps();

            $table->unique(['page_id', 'section_identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
        Schema::dropIfExists('pages');
    }
};
