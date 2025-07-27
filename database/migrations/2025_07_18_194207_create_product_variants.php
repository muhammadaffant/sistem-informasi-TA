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
 Schema::create('product_variants', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id')->constrained()->onDelete('cascade');
    $table->string('size');
    $table->integer('price');
    $table->integer('discount')->nullable();
    $table->integer('price_after_discount')->nullable();
    $table->integer('quantity')->default(0);
    $table->timestamps();

    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
