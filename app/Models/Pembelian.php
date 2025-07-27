<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}
