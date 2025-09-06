<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        Karyawan::truncate();
        
        $karyawan = [
            [
                'nip' => 'KRY001',
                'nama' => 'Ahmad Fauzi',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'gaji_pokok' => 4000000,
                'tunjangan_kehadiran' => 500000,
                'uang_lembur' => 100000, // utang
            ],
            [
                'nip' => 'KRY002',
                'nama' => 'Siti Rahayu',
                'alamat' => 'Jl. Sudirman No. 45, Jakarta Selatan',
                'gaji_pokok' => 3500000,
                'tunjangan_kehadiran' => 400000,
                'uang_lembur' => 50000, // utang
            ],
            [
                'nip' => 'KRY003',
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Gatot Subroto No. 67, Jakarta Barat',
                'gaji_pokok' => 4500000,
                'tunjangan_kehadiran' => 600000,
                'uang_lembur' => 75000, // utang
            ],
            [
                'nip' => 'KRY004',
                'nama' => 'Rina Wati',
                'alamat' => 'Jl. Thamrin No. 89, Jakarta Utara',
                'gaji_pokok' => 3800000,
                'tunjangan_kehadiran' => 450000,
                'uang_lembur' => 25000, // utang
            ],
            [
                'nip' => 'KRY005',
                'nama' => 'Dedi Kurniawan',
                'alamat' => 'Jl. HR Rasuna Said No. 12, Jakarta Timur',
                'gaji_pokok' => 4200000,
                'tunjangan_kehadiran' => 550000,
                'uang_lembur' => 150000, // utang
            ]
        ];

        foreach ($karyawan as $data) {
            Karyawan::create($data);
        }
    }
}
