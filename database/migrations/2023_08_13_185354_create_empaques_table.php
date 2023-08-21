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
        Schema::create('empaques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cultivo_id');
            $table->foreign('cultivo_id')->references('id')->on('cultivos');
            $table->integer('num_bolsas');
            $table->integer('gramos');
            $table->string('encargado')->nullable();
            $table->decimal('temp_inicial', $precision = 10, $scale = 1)->default('0.0')->nullable();
            $table->decimal('temp_final', $precision = 10, $scale = 1)->default('0.0')->nullable();
            $table->decimal('H2O', $precision = 10, $scale = 1)->default('0.0')->nullable();
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empaques');
    }
};
