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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios');
            $table->enum('estado', ['pendiente', 'preparando', 'listo', 'entregado', 'cancelado'])->default('pendiente');
            $table->enum('tipo_servicio', ['domicilio', 'recoger']);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->text('direccion_entrega')->nullable();
            $table->string('telefono_contacto', 20)->nullable();
            $table->text('notas_especiales')->nullable();
            $table->string('metodo_pago', 50)->nullable();
            $table->enum('tipo_moneda', ['nacional', 'internacional'])->default('internacional');
            $table->json('datos_pago_nacional')->nullable();
            $table->timestamp('fecha_orden')->useCurrent();
            $table->timestamp('fecha_entrega_estimada')->nullable();
            $table->foreignId('empleado_asignado_id')->nullable()->constrained('usuarios');
            
            // Timestamps de seguimiento de estados
            $table->timestamp('fecha_pendiente')->nullable()->useCurrent()->comment('Fecha cuando se crea la orden');
            $table->timestamp('fecha_preparando')->nullable()->comment('Fecha cuando se inicia la preparación');
            $table->timestamp('fecha_listo')->nullable()->comment('Fecha cuando está listo para entrega/recoger');
            $table->timestamp('fecha_en_camino')->nullable()->comment('Fecha cuando sale para entrega (solo domicilio)');
            $table->timestamp('fecha_entregado')->nullable()->comment('Fecha cuando se completa la entrega');
            $table->timestamp('fecha_cancelado')->nullable()->comment('Fecha cuando se cancela la orden');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
