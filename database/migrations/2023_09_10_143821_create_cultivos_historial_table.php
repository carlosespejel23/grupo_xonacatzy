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
        Schema::create('cultivos_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cultivo_id');
            $table->foreign('cultivo_id', 'fk_cultivo_historial')->references('id')->on('cultivos')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('provedor_id');
            $table->foreign('provedor_id', 'fk_provedor_cultivo_historial')->references('id')->on('provedores')->onDelete('restrict')->onUpdate('cascade');
            $table->string('nombre');
            $table->string('nombre_tecnico')->nullable();
            $table->integer('cantidad');
            $table->date('fecha_ingreso');
            $table->string('encargado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultivos_historial');
    }
};
