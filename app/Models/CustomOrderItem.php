<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_order_id',
        'bahan_id',
        'size_id',
        'jenis_sablon_id',
        'quantity',
        'bahan_price',
        'sablon_price',
        'subtotal',
    ];

    /**
     * Relasi ke CustomOrder
     */
    public function customOrder()
    {
        return $this->belongsTo(CustomOrder::class);
    }

    /**
     * Relasi ke Bahan
     */
    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }

    /**
     * Relasi ke Size
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    /**
     * Relasi ke JenisSablon
     */
    public function jenisSablon()
    {
        return $this->belongsTo(JenisSablon::class);
    }
}
