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
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('identificador de la categoría');
            $table->string('name', 100)->comment('nombre de la categoría');
            $table->text('description')->nullable()->comment('descripción de la categoría');
            $table->string('image', 255)->nullable()->comment('ruta de la imagen de la categoría');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('estado de la categoría');
            $table->integer('order_show')->default(0)->comment('orden de visualización de la categoría');
            $table->timestamp('created_at')->nullable()->comment('fecha de creación del registro');
            $table->timestamp('updated_at')->nullable()->comment('fecha de última actualización del registro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
