<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSablon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sablon_category_id',
        'nama_sablon',
        'harga',
    ];

    /**
     * Get the category that owns the JenisSablon.
     */
    public function sablonCategory()
    {
        return $this->belongsTo(SablonCategory::class);
    }
}
