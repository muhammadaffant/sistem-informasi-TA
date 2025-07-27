<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk Cotton Combed 30s (bahan_id = 1)
        DB::table('sizes')->insert([
            [
                'bahan_id' => 1,
                'nama_size' => 'L (Lengan Panjang)',
                'price' => 40000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 1,
                'nama_size' => 'L (Lengan Pendek)',
                'price' => 35000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 1,
                'nama_size' => 'M (Lengan Panjang)',
                'price' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 1,
                'nama_size' => 'S (Lengan Pendek)',
                'price' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 1,
                'nama_size' => 'M (Lengan Pendek)',
                'price' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 1,
                'nama_size' => 'S (Lengan Panjang)',
                'price' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Data untuk Cotton Combed 24s (bahan_id = 2)
        DB::table('sizes')->insert([
            [
                'bahan_id' => 2,
                'nama_size' => 'S (Lengan Pendek)',
                'price' => 22000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 2,
                'nama_size' => 'S (Lengan Panjang)',
                'price' => 27000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'bahan_id' => 2,
                'nama_size' => 'M (Lengan Pendek)',
                'price' => 27000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 2,
                'nama_size' => 'M (Lengan Panjang)',
                'price' => 32000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'bahan_id' => 2,
                'nama_size' => 'L (Lengan Pendek)',
                'price' => 37000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bahan_id' => 2,
                'nama_size' => 'L (Lengan Panjang)',
                'price' => 42000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
