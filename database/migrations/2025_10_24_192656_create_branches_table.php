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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('direccion', 255);
            $table->string('ciudad', 100);
            $table->string('estado', 100);
            $table->string('codigo_postal', 20)->nullable();
            $table->string('telefono', 20);
            $table->string('email', 100)->nullable();
            $table->time('horario_apertura')->default('09:00:00');
            $table->time('horario_cierre')->default('22:00:00');
            $table->string('dias_operacion', 100)->default('Lunes a Domingo');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->boolean('es_principal')->default(false);
            $table->boolean('tiene_delivery')->default(true);
            $table->boolean('tiene_estacionamiento')->default(false);
            $table->integer('capacidad_personas')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->date('fecha_apertura')->nullable();
            $table->string('gerente', 100)->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            
            $table->index('ciudad');
            $table->index('activo');
            $table->index('es_principal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
