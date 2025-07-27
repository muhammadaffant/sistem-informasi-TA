<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanans';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pesananDetail()
    {
        return $this->hasMany(PesananDetail::class);
    }
}
