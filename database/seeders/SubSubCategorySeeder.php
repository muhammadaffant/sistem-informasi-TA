<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subSubCategories = [
            ['category_id' => 1, 'sub_category_id' => 1, 'subsubcategory_name' => 'Kaos Polos Lengan Panjang'],
            ['category_id' => 1, 'sub_category_id' => 1, 'subsubcategory_name' => 'Kaos Polos Lengan Pendek'],
            // ['category_id' => 1, 'sub_category_id' => 2, 'subsubcategory_name' => 'Kaos Bergambar Kartun'],
            ['category_id' => 1, 'sub_category_id' => 2, 'subsubcategory_name' => 'Kaos Bergambar Logo'],
            ['category_id' => 2, 'sub_category_id' => 3, 'subsubcategory_name' => 'Kemeja Formal Slim Fit'],
            ['category_id' => 2, 'sub_category_id' => 3, 'subsubcategory_name' => 'Kemeja Formal Regular Fit'],
            // ['category_id' => 2, 'sub_category_id' => 4, 'subsubcategory_name' => 'Kemeja Kasual Denim'],
            ['category_id' => 2, 'sub_category_id' => 4, 'subsubcategory_name' => 'Kemeja Kasual Flanel'],
            // ['category_id' => 3, 'sub_category_id' => 5, 'subsubcategory_name' => 'Jaket Kulit Asli'],
            // ['category_id' => 3, 'sub_category_id' => 6, 'subsubcategory_name' => 'Jaket Jeans Ripped'],
        ];

        foreach ($subSubCategories as $subSubCategory) {
            DB::table('sub_sub_categories')->insert([
                'category_id' => $subSubCategory['category_id'],
                'sub_category_id' => $subSubCategory['sub_category_id'],
                'subsubcategory_name' => $subSubCategory['subsubcategory_name'],
                'subsubcategory_slug' => Str::slug($subSubCategory['subsubcategory_name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
