<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
