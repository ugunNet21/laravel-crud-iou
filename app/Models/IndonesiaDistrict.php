<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndonesiaDistrict extends Model
{
    use HasFactory;
    protected $table = 'indonesia_districts';

    public function city()
    {
        return $this->belongsTo(IndonesiaCity::class, 'city_code', 'code');
    }

    public function villages()
    {
        return $this->hasMany(IndonesiaVillage::class, 'district_code', 'code');
    }
}
