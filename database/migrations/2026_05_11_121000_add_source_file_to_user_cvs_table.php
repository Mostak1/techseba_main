<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            if (! Schema::hasColumn('user_cvs', 'source_file')) {
                $table->string('source_file')->nullable()->after('signature');
            }

            if (! Schema::hasColumn('user_cvs', 'source_file_original_name')) {
                $table->string('source_file_original_name')->nullable()->after('source_file');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            if (Schema::hasColumn('user_cvs', 'source_file_original_name')) {
                $table->dropColumn('source_file_original_name');
            }

            if (Schema::hasColumn('user_cvs', 'source_file')) {
                $table->dropColumn('source_file');
            }
        });
    }
};
