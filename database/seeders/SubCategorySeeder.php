<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            ['category_id' => 1, 'subcategory_name' => 'Kaos Polos'],
            ['category_id' => 1, 'subcategory_name' => 'Kaos Bergambar'],
            ['category_id' => 2, 'subcategory_name' => 'Kemeja Formal'],
            ['category_id' => 2, 'subcategory_name' => 'Kemeja Kasual'],
            // ['category_id' => 3, 'subcategory_name' => 'Jaket Kulit'],
            // ['category_id' => 3, 'subcategory_name' => 'Jaket Jeans'],
            // ['category_id' => 4, 'subcategory_name' => 'Celana Jeans'],
            // ['category_id' => 4, 'subcategory_name' => 'Celana Chino'],
            // ['category_id' => 5, 'subcategory_name' => 'Seragam Sekolah'],
            // ['category_id' => 5, 'subcategory_name' => 'Seragam Kerja'],
        ];

        foreach ($subCategories as $subCategory) {
            DB::table('sub_categories')->insert([
                'category_id' => $subCategory['category_id'],
                'subcategory_name' => $subCategory['subcategory_name'],
                'subcategory_slug' => Str::slug($subCategory['subcategory_name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
