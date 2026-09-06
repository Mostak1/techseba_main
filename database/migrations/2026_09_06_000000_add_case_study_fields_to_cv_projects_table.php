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
        Schema::table('cv_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('cv_projects', 'github_url')) {
                $table->string('github_url')->nullable()->after('link');
            }
            if (!Schema::hasColumn('cv_projects', 'technologies')) {
                $table->text('technologies')->nullable()->after('github_url');
            }
            if (!Schema::hasColumn('cv_projects', 'role')) {
                $table->string('role')->nullable()->after('technologies');
            }
            if (!Schema::hasColumn('cv_projects', 'problem')) {
                $table->text('problem')->nullable()->after('role');
            }
            if (!Schema::hasColumn('cv_projects', 'solution')) {
                $table->text('solution')->nullable()->after('problem');
            }
            if (!Schema::hasColumn('cv_projects', 'image')) {
                $table->string('image')->nullable()->after('solution');
            }
            if (!Schema::hasColumn('cv_projects', 'demo_user')) {
                $table->string('demo_user')->nullable()->after('image');
            }
            if (!Schema::hasColumn('cv_projects', 'demo_password')) {
                $table->string('demo_password')->nullable()->after('demo_user');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv_projects', function (Blueprint $table) {
            $table->dropColumn(['github_url', 'technologies', 'role', 'problem', 'solution', 'image', 'demo_user', 'demo_password']);
        });
    }
};
