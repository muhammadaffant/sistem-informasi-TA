<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananDetail extends Model
{
    use HasFactory;
    protected $table = 'pesanan_detail';

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
