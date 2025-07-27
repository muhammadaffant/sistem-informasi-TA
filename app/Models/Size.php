<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'bahan_id',
        'nama_size',
        'price',
    ];

    /**
     * Relasi ke model Bahan
     */
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
}
