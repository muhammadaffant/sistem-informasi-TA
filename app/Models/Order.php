<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Builder;
// use App\Models\Product;


class Order extends Model
{
    use HasFactory;


        protected $casts = [
        'order_date' => 'datetime',
    ];
    public function scopeSuccess(Builder $query): void
    {
        $query->where('status', 'Success');
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function regency() {
        return $this->belongsTo(Regency::class);
    }
    public function district() {
        return $this->belongsTo(District::class);
    }
    public function village() {
        return $this->belongsTo(Village::class);
    }

}
