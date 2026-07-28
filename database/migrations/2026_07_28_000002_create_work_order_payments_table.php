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
        Schema::create('work_order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('payment_method'); // Bkash, Rocket, Nagad, Bank, Cash, etc.
            $table->string('transaction_id')->nullable();
            $table->date('payment_date');
            $table->string('status')->default('pending'); // pending, confirmed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_payments');
    }
};
