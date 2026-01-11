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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost_price', 10, 2); // lo que le cuesta al negocio
            $table->decimal('sale_price', 10, 2); // lo que se vende al cliente
            $table->integer('stock')->default(0);
            $table->boolean('active')->default(true);
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('entity_id')->constrained('entities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
