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
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('subsubcategory_id');
            $table->string('product_code', 30);
            $table->string('product_name', 30);
            $table->string('product_slug', 100);
            $table->integer('product_qty')->default(0);
            $table->string('product_tags')->nullable();
            $table->string('product_size', 10)->nullable();
            $table->string('product_color', 30)->nullable();
            $table->integer('selling_price')->default(0);
            $table->integer('discount_price')->default(0);
            $table->text('short_descp')->nullable();
            $table->longText('long_descp')->nullable();
            $table->string('product_thumbnail', 100)->default('product_thumbnail.jpg');
            // $table->integer('hot_deals')->default(0);
            // $table->integer('featured')->default(0);
            // $table->integer('special_offer')->default(0);
            $table->integer('status')->default(0);
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
