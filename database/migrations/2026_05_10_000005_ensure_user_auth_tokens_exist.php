<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $needsVerificationToken = ! Schema::hasColumn('users', 'verification_token');
        $needsForgetPasswordToken = ! Schema::hasColumn('users', 'forget_password_token');

        if ($needsVerificationToken || $needsForgetPasswordToken) {
            Schema::table('users', function (Blueprint $table) use ($needsVerificationToken, $needsForgetPasswordToken) {
                if ($needsVerificationToken) {
                $table->string('verification_token')->nullable()->after('password');
                }

                if ($needsForgetPasswordToken) {
                    $table->string('forget_password_token')->nullable()->after('verification_token');
                }
            });
        }
    }

    public function down(): void
    {
        $hasForgetPasswordToken = Schema::hasColumn('users', 'forget_password_token');
        $hasVerificationToken = Schema::hasColumn('users', 'verification_token');

        if ($hasForgetPasswordToken || $hasVerificationToken) {
            Schema::table('users', function (Blueprint $table) use ($hasForgetPasswordToken, $hasVerificationToken) {
                if ($hasForgetPasswordToken) {
                $table->dropColumn('forget_password_token');
                }

                if ($hasVerificationToken) {
                    $table->dropColumn('verification_token');
                }
            });
        }
    }
};
