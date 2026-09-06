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
            $table->dropColumn(['demo_user', 'demo_password']);
        });
    }
};
