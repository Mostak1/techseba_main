<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYoutubeTiktokToFooters extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('footers', function (Blueprint $table) {
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('footers', function (Blueprint $table) {
            $table->dropColumn(['youtube', 'tiktok']);
        });
    }
}
