<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomOrder extends Model
{
    use HasFactory;
    protected $table = 'custom_orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
