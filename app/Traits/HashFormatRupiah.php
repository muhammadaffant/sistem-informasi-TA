<?php

namespace App\Traits;

/** 
 * Trait HashFormatRupiah 
 */
trait HashFormatRupiah
{
    function formatRupiah($field, $prefix = null)
    {
        $prefix = $prefix ? $prefix : 'Rp. ';
        return $prefix . number_format($this->attributes[$field], 0, ',', ',');
    }
}
