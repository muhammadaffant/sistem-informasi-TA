<?php

namespace App\Models;

use App\Traits\HashFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;
    use HashFormatRupiah;
    protected $table = 'produks';

    /**
     * relasi many to one
     *
     * @return void
     */
    public function produkDetails()
    {
        return $this->hasMany(ProdukDetail::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
