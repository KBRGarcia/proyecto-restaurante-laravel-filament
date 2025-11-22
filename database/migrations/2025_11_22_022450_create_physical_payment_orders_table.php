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
        Schema::create('physical_payment_orders', function (Blueprint $table) {
            $table->id()->comment('identificador de la orden de pago físico');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->comment('identificador de la orden');
            $table->timestamp('limit_date')->comment('fecha límite para el pago');
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending')->comment('estado de la orden de pago');
            $table->timestamp('creation_date')->useCurrent()->comment('fecha de creación');
            $table->timestamp('update_date')->useCurrent()->useCurrentOnUpdate()->comment('fecha de actualización');
            $table->timestamps();
            
            // Índices
            $table->index('limit_date', 'idx_limit_date');
            $table->index('status', 'idx_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_payment_orders');
    }
};
