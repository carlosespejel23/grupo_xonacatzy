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
        Schema::create('ventas_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mercado_id');
            $table->foreign('mercado_id')->references('id')->on('mercados')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('cantidad');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_productos');
    }
};
