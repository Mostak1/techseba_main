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

            if (! Schema::hasColumn('user_cvs', 'source_text')) {
                $table->longText('source_text')->nullable()->after('source_file_original_name');
            }

            if (! Schema::hasColumn('user_cvs', 'source_extract_status')) {
                $table->string('source_extract_status')->nullable()->after('source_text');
            }

            if (! Schema::hasColumn('user_cvs', 'source_extracted_at')) {
                $table->timestamp('source_extracted_at')->nullable()->after('source_extract_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_cvs', function (Blueprint $table) {
            if (Schema::hasColumn('user_cvs', 'source_extracted_at')) {
                $table->dropColumn('source_extracted_at');
            }

            if (Schema::hasColumn('user_cvs', 'source_extract_status')) {
                $table->dropColumn('source_extract_status');
            }

            if (Schema::hasColumn('user_cvs', 'source_text')) {
                $table->dropColumn('source_text');
            }

            if (Schema::hasColumn('user_cvs', 'source_file_original_name')) {
                $table->dropColumn('source_file_original_name');
            }

            if (Schema::hasColumn('user_cvs', 'source_file')) {
                $table->dropColumn('source_file');
            }
        });
    }
};
