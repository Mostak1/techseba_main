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
        Schema::table('profile_domains', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_domains', 'status')) {
                $table->string('status')->default('pending')->after('type'); // pending, reviewing, complete, canceled
            }
            if (!Schema::hasColumn('profile_domains', 'user_note')) {
                $table->text('user_note')->nullable()->after('status');
            }
            if (!Schema::hasColumn('profile_domains', 'admin_message')) {
                $table->text('admin_message')->nullable()->after('user_note');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_domains', function (Blueprint $table) {
            if (Schema::hasColumn('profile_domains', 'admin_message')) {
                $table->dropColumn('admin_message');
            }
            if (Schema::hasColumn('profile_domains', 'user_note')) {
                $table->dropColumn('user_note');
            }
            if (Schema::hasColumn('profile_domains', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
