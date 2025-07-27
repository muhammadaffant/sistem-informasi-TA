<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSablon; // Pastikan Anda mengimpor model JenisSablon
use App\Models\SablonCategory;
use Illuminate\Support\Facades\DB;

class JenisSablonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menghapus data sebelumnya untuk menghindari duplikasi jika seeder dijalankan berulang
        // HANYA JIKA Anda ingin tabel JenisSablon bersih sebelum ditambahkan data ini.
        // Jika tidak, hapus baris di bawah ini.
        // Nonaktifkan foreign key check untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel untuk menghindari duplikasi data
        JenisSablon::truncate();
        SablonCategory::truncate();

        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- TAHAP 1: BUAT KATEGORI SABLON ---
        $plastisol = SablonCategory::create(['name' => 'Plastisol']);
        $rubber = SablonCategory::create(['name' => 'Rubber']);
        $dtf = SablonCategory::create(['name' => 'DTF (Direct to Film)']);
        $polyflex = SablonCategory::create(['name' => 'Polyflex']);


        // --- TAHAP 2: BUAT JENIS SABLON BERDASARKAN KATEGORI ---

        // Jenis Sablon untuk Kategori PLASTISOL
        JenisSablon::create([
            'sablon_category_id' => $plastisol->id,
            'nama_sablon' => 'Logo Kecil (Max 10x10 cm)',
            'harga' => 5000,
        ]);
        JenisSablon::create([
            'sablon_category_id' => $plastisol->id,
            'nama_sablon' => 'Logo Sedang (Max 15x20 cm)',
            'harga' => 8000,
        ]);
        JenisSablon::create([
            'sablon_category_id' => $plastisol->id,
            'nama_sablon' => 'Hanya Tulisan (Max A4)',
            'harga' => 5000,
        ]);
        JenisSablon::create([
            'sablon_category_id' => $plastisol->id,
            'nama_sablon' => 'Full Depan (Ukuran A3)',
            'harga' => 15000,
        ]);
        JenisSablon::create([
            'sablon_category_id' => $plastisol->id,
            'nama_sablon' => 'Full Belakang (Ukuran A3)',
            'harga' => 20000,
        ]);

        // Jenis Sablon untuk Kategori RUBBER
        JenisSablon::create([
            'sablon_category_id' => $rubber->id,
            'nama_sablon' => 'Logo Kecil (Max 10x10 cm)',
            'harga' => 4000,
        ]);
        JenisSablon::create([
            'sablon_category_id' => $rubber->id,
            'nama_sablon' => 'Full Depan (Ukuran A3)',
            'harga' => 12000,
        ]);

        // Jenis Sablon untuk Kategori DTF
        JenisSablon::create([
            'sablon_category_id' => $dtf->id,
            'nama_sablon' => 'Logo Dada',
            'harga' => 7000,
        ]);
        JenisSablon::create([
            'sablon_category_id' => $dtf->id,
            'nama_sablon' => 'Gambar Ukuran A4',
            'harga' => 18000,
        ]);
    }
}