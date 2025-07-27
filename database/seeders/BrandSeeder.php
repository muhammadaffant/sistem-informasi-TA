<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['brand_name' => 'Nike', 'brand_image' => 'nike.jpg'],
            // ['brand_name' => 'Adidas', 'brand_image' => 'adidas.jpg'],
            // ['brand_name' => 'Puma', 'brand_image' => 'puma.jpg'],
            // ['brand_name' => 'Reebok', 'brand_image' => 'reebok.jpg'],
            // ['brand_name' => 'Under Armour', 'brand_image' => 'underarmour.jpg'],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'brand_name' => $brand['brand_name'],
                // 'brand_slug' => Str::slug($brand['brand_name']),
                // 'brand_image' => $brand['brand_image'] ?? 'brand.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
