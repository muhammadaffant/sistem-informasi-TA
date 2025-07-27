<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subSubCategory()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}
