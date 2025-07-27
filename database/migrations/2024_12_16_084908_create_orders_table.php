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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('village_id')->nullable();
            $table->string('name', 30);
            $table->string('email', 30);
            $table->string('phone', 13);
            $table->string('post_code', 5);
            $table->text('notes')->nullable();
            $table->text('address')->nullable();
            
            // Kolom Pembayaran
            $table->string('payment_type', 30)->nullable();
            $table->string('transaction_id')->nullable();
            $table->bigInteger('amount');
            $table->string('invoice_no', 20)->nullable();
            
            // Kolom Status dan Waktu Kejadian (Gunakan timestamp!)
            $table->string('status', 20); // Beri nilai default
            $table->timestamp('confirmed_date')->nullable();
            $table->timestamp('processing_date')->nullable();
            $table->timestamp('picked_date')->nullable();
            $table->timestamp('shipped_date')->nullable();
            $table->timestamp('delivered_date')->nullable();
            $table->timestamp('cancel_date')->nullable();
            $table->timestamp('return_date')->nullable();
            
            // created_at akan menjadi tanggal order secara otomatis
            // updated_at akan diupdate setiap ada perubahan
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};