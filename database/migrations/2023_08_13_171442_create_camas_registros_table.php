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
        Schema::create('camas_registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registro_id');
            $table->foreign('registro_id', 'fk_registro_cama')->references('id')->on('registros')->onDelete('cascade')->onUpdate('cascade');
            $table->string('num_cama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camas_registros');
    }
};
