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
        Schema::create('producto_sucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained('branches')->onDelete('cascade');
            $table->boolean('disponible')->default(true);
            $table->decimal('precio_especial', 10, 2)->nullable()->comment('Precio especial para esta sucursal (opcional)');
            $table->timestamp('fecha_asignacion')->useCurrent();
            
            $table->unique(['producto_id', 'sucursal_id'], 'unique_producto_sucursal');
            $table->index('producto_id');
            $table->index('sucursal_id');
            $table->index('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_sucursal');
    }
};
