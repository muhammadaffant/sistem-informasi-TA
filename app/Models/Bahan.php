<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bahan extends Model
{
    use HasFactory;
    // protected $table = 'bahans';
    protected $guarded = ['id'];

        public function sizes()
    {
        return $this->hasMany(Size::class, 'bahan_id');
    }
}
