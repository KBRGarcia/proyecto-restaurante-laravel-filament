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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('orden_id')->nullable()->constrained('ordenes');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->integer('calificacion')->check('calificacion >= 1 AND calificacion <= 5');
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_evaluacion')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
