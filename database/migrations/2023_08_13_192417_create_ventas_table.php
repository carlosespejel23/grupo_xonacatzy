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
        Schema::create('ventas_cultivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mercado_id');
            $table->foreign('mercado_id')->references('id')->on('mercados')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('cultivo_id');
            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('cantidad');
            $table->decimal('monto', $precision = 10, $scale = 2)->default('0.00');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_cultivos');
    }
};
