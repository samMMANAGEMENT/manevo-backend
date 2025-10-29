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
        Schema::create('plans', function (Blueprint $table) {
            // Define los planes disponibles (freemium, pro, enterprise…)
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->integer('duracion_dias');
            $table->boolean('es_predeterminado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
