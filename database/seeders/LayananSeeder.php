<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan dummy data menggunakan DB facade
        $layanans = [
            // [
            //     'nama_layanan' => 'Jahit Pakaian',
            //     'deskripsi' => 'Layanan untuk menjahit pakaian sesuai dengan ukuran dan desain yang diinginkan.',
            // ],
            // [
            //     'nama_layanan' => 'Pembuatan Seragam',
            //     'deskripsi' => 'Layanan khusus untuk pembuatan seragam kantor, sekolah, atau komunitas.',
            // ],
            [
                'nama_layanan' => 'Custom Kaos',
                'deskripsi' => 'Layanan untuk membuat pakaian dengan desain khusus sesuai permintaan pelanggan.',
            ],
            // [
            //     'nama_layanan' => 'Perbaikan Pakaian',
            //     'deskripsi' => 'Layanan perbaikan pakaian seperti menjahit sobekan, mengganti kancing, dan lainnya.',
            // ],
            // [
            //     'nama_layanan' => 'Pembuatan Jaket',
            //     'deskripsi' => 'Layanan pembuatan jaket untuk keperluan pribadi, komunitas, atau perusahaan.',
            // ],
        ];

        foreach ($layanans as $layanan) {
            DB::table('layanans')->insert([
                'nama_layanan' => $layanan['nama_layanan'],
                'deskripsi' => $layanan['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
