<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomOrder extends Model
{
    use HasFactory;
    protected $table = 'custom_orders';

    protected $fillable = [
        'user_id',
        'name',
        'file_design',
        'file_design_front',
        'file_design_back',
        'design_description',
        'fabric_type',
        'sablon_price',
        'size',
        'total_price',
        'dp_paid',
        'remaining_payment',
        'status',
        'order_date',
        'completion_date',
        'address',
        'province_id',
        'regency_id', // Menambahkan regency_id
        'city_id',
        'district_id',
        'village_id',
        'ongkir',
        'courier',
        'courier_service',
        'courir', // Menambahkan courir field
        'position',
        'front_position',
        'back_position',
        'qty',
        'jenis_sablon',
        'estimated_days', // Estimasi hari pengerjaan
        'total_weight' // Total berat pesanan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke CustomOrderItem (Multi-variasi)
     */
    public function customOrderItems()
    {
        return $this->hasMany(CustomOrderItem::class);
    }

    /**
     * Hitung estimasi hari pengerjaan berdasarkan kuantitas
     */
    public static function calculateEstimatedDays($totalQuantity)
    {
        if ($totalQuantity <= 12) {
            return 3; // 3 hari untuk kuantitas 12 atau kurang
        } elseif ($totalQuantity <= 50) {
            return 5; // 5 hari untuk kuantitas 13-50
        } elseif ($totalQuantity <= 100) {
            return 7; // 7 hari untuk kuantitas 51-100
        } elseif ($totalQuantity <= 200) {
            return 10; // 10 hari untuk kuantitas 101-200
        } else {
            return 14; // 14 hari untuk kuantitas lebih dari 200
        }
    }

    /**
     * Get formatted estimated completion date
     */
    public function getEstimatedCompletionDateAttribute()
    {
        if ($this->estimated_days && $this->order_date) {
            return \Carbon\Carbon::parse($this->order_date)->addDays($this->estimated_days);
        }
        return null;
    }

    /**
     * Get formatted weight
     */
    public function getFormattedWeightAttribute()
    {
        if ($this->total_weight >= 1000) {
            return number_format($this->total_weight / 1000, 1) . ' kg';
        }
        return $this->total_weight . ' gram';
    }
}
