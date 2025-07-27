<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AzisHapidin\IndoRegion\Traits\ProvinceTrait;

class Ongkir extends Model
{
    use HasFactory;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
