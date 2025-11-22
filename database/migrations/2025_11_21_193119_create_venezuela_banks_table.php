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
        Schema::create('venezuela_banks', function (Blueprint $table) {
            $table->id()->comment('identificador del banco');
            $table->string('code', 10)->unique()->comment('código del banco');
            $table->string('name', 100)->comment('nombre del banco');
            $table->boolean('active')->default(true)->comment('estado del banco');
            $table->json('system_data')->nullable()->comment('datos del sistema en formato JSON');
            $table->timestamp('creation_date')->useCurrent()->comment('fecha de creación');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venezuela_banks');
    }
};
