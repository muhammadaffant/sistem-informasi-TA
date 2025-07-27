<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanPakaian = [
            [
                'nama_bahan' => 'Cotton Combed 30s',
                // 'keterangan' => 'Bahan yang terbuat dari serat alami, lembut, nyaman, dan menyerap keringat.',
            ],
            [
                'nama_bahan' => 'Cotton Combed 24s',
                // 'keterangan' => 'Bahan sintetis yang tahan lama, tidak mudah kusut, dan cepat kering.',
            ],
            // [
            //     'nama_bahan' => 'Denim',
            //     'keterangan' => 'Bahan yang kuat dan sering digunakan untuk celana atau jaket.',
            // ],
            // [
            //     'nama_bahan' => 'Linen',
            //     'keterangan' => 'Bahan yang ringan, adem, dan cocok untuk pakaian musim panas.',
            // ],
            // [
            //     'nama_bahan' => 'Spandex',
            //     'keterangan' => 'Bahan elastis yang sering digunakan untuk pakaian olahraga atau ketat.',
            // ],
            // [
            //     'nama_bahan' => 'Wol',
            //     'keterangan' => 'Bahan yang hangat, cocok untuk pakaian musim dingin.',
            // ],
            // [
            //     'nama_bahan' => 'Rayon',
            //     'keterangan' => 'Bahan yang halus, nyaman, dan memiliki kilauan seperti sutra.',
            // ],
            // [
            //     'nama_bahan' => 'Sifon',
            //     'keterangan' => 'Bahan ringan, transparan, dan sering digunakan untuk pakaian formal.',
            // ],
            // [
            //     'nama_bahan' => 'Satin',
            //     'keterangan' => 'Bahan yang licin dan mengkilap, sering digunakan untuk pakaian pesta.',
            // ],
            // [
            //     'nama_bahan' => 'Drill',
            //     'keterangan' => 'Bahan yang kuat, tahan lama, dan sering digunakan untuk seragam.',
            // ],
        ];

        DB::table('bahans')->insert($bahanPakaian);
    }
}
