<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembelianDetail extends Model
{
    use HasFactory;

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }


    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
