<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('email');
            });
        }

        $duplicates = DB::table('users')
            ->select('username')
            ->whereNotNull('username')
            ->where('username', '!=', '')
            ->groupBy('username')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('username');

        if ($duplicates->isNotEmpty()) {
            throw new RuntimeException(
                'Duplicate users.username values found. Resolve duplicates before adding the unique index: '.$duplicates->implode(', ')
            );
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username', 'users_username_unique');
        });
    }

    public function down(): void
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_username_unique');
            });
        } catch (Throwable $exception) {
            //
        }
    }
};
