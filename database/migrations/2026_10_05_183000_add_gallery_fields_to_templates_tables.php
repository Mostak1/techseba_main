<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('category')->nullable()->index()->after('description');
            $table->string('style')->nullable()->after('category');
            $table->boolean('is_premium')->default(false)->after('style');
            $table->integer('sort_order')->default(0)->index()->after('is_premium');
        });

        Schema::table('portfolio_templates', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('category')->nullable()->index()->after('description');
            $table->string('style')->nullable()->after('category');
            $table->boolean('is_premium')->default(false)->after('style');
            $table->integer('sort_order')->default(0)->index()->after('is_premium');
        });
    }

    public function down(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->dropColumn(['description', 'category', 'style', 'is_premium', 'sort_order']);
        });

        Schema::table('portfolio_templates', function (Blueprint $table) {
            $table->dropColumn(['description', 'category', 'style', 'is_premium', 'sort_order']);
        });
    }
};
