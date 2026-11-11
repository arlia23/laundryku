<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_code')->unique();

        $table->foreignId('customer_id')
            ->constrained('users')
            ->restrictOnDelete();

        $table->foreignId('machine_id')
            ->nullable()
            ->constrained('machines')
            ->nullOnDelete();

        $table->date('order_date');
        $table->decimal('total_price', 12, 2);

        $table->enum('status', [
            'pending', 'confirmed', 'processing',
            'ready', 'completed', 'cancelled'
        ])->default('pending');

        $table->enum('payment_status', [
            'unpaid', 'paid'
        ])->default('unpaid');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};