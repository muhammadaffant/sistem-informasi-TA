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
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 30);
            $table->string('file_design')->default('design.jpg');
            $table->text('design_description')->nullable();
            $table->string('fabric_type', 50)->nullable(); // bahan
            $table->text('sablon_price')->nullable(); // bahan
            $table->text('size')->nullable(); //ukuran baju
            $table->bigInteger('total_price')->default(0);
            $table->bigInteger('dp_paid')->default(0);
            $table->bigInteger('remaining_payment')->default(0); // sisa pembayaran
            $table->string('status')->default('Pending');
            $table->dateTime('order_date');
            $table->dateTime('completion_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};
