<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'size', 'price', 'discount', 'price_after_discount', 'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
