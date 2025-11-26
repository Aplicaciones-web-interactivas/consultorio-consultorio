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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('IdPaciente')->unsigned();
            $table->bigInteger('IdDoctor')->unsigned();
            $table->foreign('IdPaciente')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('IdDoctor')->references('id')->on('users')->onDelete('cascade');
            $table->date('Fecha');
            $table->time('Hora');
            $table->boolean('Confirmacion')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
