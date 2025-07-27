<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SablonCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function jenisSablons()
    {
        return $this->hasMany(JenisSablon::class);
    }
}
