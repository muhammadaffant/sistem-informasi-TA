<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Kaos'],
            ['category_name' => 'Kemeja'],
            // ['category_name' => 'Jaket', 'category_icon' => 'fa-solid fa-jacket'],
            // ['category_name' => 'Celana', 'category_icon' => 'fa-solid fa-pants'],
            // ['category_name' => 'Seragam', 'category_icon' => 'fa-solid fa-user-tie'],
            // ['category_name' => 'Pakaian Anak', 'category_icon' => 'fa-solid fa-child'],
            // ['category_name' => 'Pakaian Olahraga', 'category_icon' => 'fa-solid fa-running'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'category_name' => $category['category_name'],
                'category_slug' => Str::slug($category['category_name']),
                // 'category_icon' => $category['category_icon'],
            ]);
        }
    }
}
