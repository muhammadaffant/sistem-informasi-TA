<?php

namespace App\Models;

use App\Traits\HashFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukDetail extends Model
{
    use HasFactory;
    use HashFormatRupiah;
    protected $table = 'produk_details';

    /**
     * relasi to produk
     *
     * @return void
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
