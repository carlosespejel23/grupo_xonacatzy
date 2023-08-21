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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provedor_id');
            $table->foreign('provedor_id', 'fk_provedor_registro')->references('id')->on('provedores')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('cultivo_id');
            $table->foreign('cultivo_id', 'fk_cultivo_provedor')->references('id')->on('cultivos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('encargado1');
            $table->date('fecha_salida');
            $table->integer('cantidad');
            $table->string('invernadero');
            $table->string('encargado2');
            $table->string('responsable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
