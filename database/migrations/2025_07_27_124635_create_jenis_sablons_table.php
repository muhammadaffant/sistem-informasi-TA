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
        Schema::create('jenis_sablons', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel kategori
            $table->foreignId('sablon_category_id')->constrained('sablon_categories')->onDelete('cascade');
            $table->string('nama_sablon', 100); // e.g., 'Logo Kecil', 'Full Depan'
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_sablons');
    }
};
