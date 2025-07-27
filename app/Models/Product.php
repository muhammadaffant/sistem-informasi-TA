<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    /**
     * Define the relationship with MultiImg.
     */
    public function multiImages()
    {
        return $this->hasMany(MultiImg::class, 'product_id');
    }

    public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

public function reviews()
{
    // Mengambil ulasan yang sudah disetujui (approved) saja
    return $this->hasMany(Review::class)->where('status', 'approved');
}

// app/Models/Product.php

// ... (kode Anda yang lain) ...

/**
 * Accessor untuk harga jual (harga awal terendah).
 */
public function getSellingPriceAttribute()
{
    // Mengambil harga awal terendah dari semua varian. Ini sudah benar.
    return $this->variants->min('price') ?? 0;
}

/**
 * Accessor untuk harga SETELAH diskon (harga akhir terendah).
 * Ini akan mencari penawaran terbaik dari semua varian.
 */
public function getPriceAfterDiscountAttribute()
{
    if ($this->variants->isEmpty()) {
        return 0;
    }

    // Hitung harga akhir untuk setiap varian, lalu cari yang termurah.
    $lowestFinalPrice = $this->variants->map(function ($variant) {
        $discountAmount = ($variant->discount / 100) * $variant->price;
        return $variant->price - $discountAmount;
    })->min();

    return $lowestFinalPrice;
}

/**
 * Accessor untuk PERSENTASE diskon.
 * Menampilkan persentase diskon dari varian yang punya penawaran terbaik.
 */
public function getDiscountPriceAttribute()
{
    if ($this->variants->isEmpty()) {
        return 0;
    }

    // Cari varian yang memiliki harga akhir termurah.
    $bestVariant = $this->variants->sortBy(function ($variant) {
        $discountAmount = ($variant->discount / 100) * $variant->price;
        return $variant->price - $discountAmount;
    })->first();

    // Kembalikan persentase diskon dari varian terbaik tersebut.
    return $bestVariant->discount ?? 0;
}

// ... (sisa relasi dan scope Anda) ...


    /**
     * Get the brand.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the SubCategory.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    /**
     * Get the SubCategory.
     */
    public function SubSubCategory(): BelongsTo
    {
        return $this->belongsTo(SubSubCategory::class, 'subsubcategory_id');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeStatus(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeTag(Builder $query, string $tag): void
    {
        $query->where('product_tags', $tag);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeSubcategory(Builder $query, string $subcategory): void
    {
        $query->where('subcategory_id', $subcategory);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeSubsubcategory(Builder $query, string $subcategory): void
    {
        $query->where('subsubcategory_id', $subcategory);
    }
}
