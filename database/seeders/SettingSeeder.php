<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = [
            'name' => 'Konveksi App',
            'sort' => 'KVS',
            'email' => 'konveksi@gmail.com',
            'phone' => '0878'
        ];

        Setting::create($setting);
    }
}
