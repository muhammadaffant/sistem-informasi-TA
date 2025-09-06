<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nip',
        'nama',
        'alamat',
        'gaji_pokok',
        'tunjangan_kehadiran',
        'uang_lembur', // akan digunakan sebagai utang
        'gaji_bersih'
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'tunjangan_kehadiran' => 'decimal:2',
        'uang_lembur' => 'decimal:2',
        'gaji_bersih' => 'decimal:2',
    ];

    /**
     * Calculate gaji bersih automatically
     */
    public function calculateGajiBersih()
    {
        $this->gaji_bersih = $this->gaji_pokok + $this->tunjangan_kehadiran - $this->uang_lembur;
        return $this->gaji_bersih;
    }

    /**
     * Override save method to calculate gaji bersih automatically
     */
    public function save(array $options = [])
    {
        $this->calculateGajiBersih();
        return parent::save($options);
    }

    /**
     * Format currency for display
     */
    public function getFormattedGajiPokokAttribute()
    {
        return 'Rp ' . number_format($this->gaji_pokok, 0, ',', '.');
    }

    public function getFormattedTunjanganKehadiranAttribute()
    {
        return 'Rp ' . number_format($this->tunjangan_kehadiran, 0, ',', '.');
    }

    public function getFormattedUangLemburAttribute()
    {
        return 'Rp ' . number_format($this->uang_lembur, 0, ',', '.');
    }

    public function getFormattedUtangAttribute()
    {
        return 'Rp ' . number_format($this->uang_lembur, 0, ',', '.');
    }

    // Accessor untuk utang
    public function getUtangAttribute()
    {
        return $this->uang_lembur;
    }

    // Mutator untuk utang
    public function setUtangAttribute($value)
    {
        $this->attributes['uang_lembur'] = $value;
    }

    public function getFormattedGajiBersihAttribute()
    {
        return 'Rp ' . number_format($this->gaji_bersih, 0, ',', '.');
    }
}
