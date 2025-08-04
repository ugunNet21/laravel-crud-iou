<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndonesiaCity extends Model
{
    use HasFactory;
    protected $table = 'indonesia_cities';

    public function province()
    {
        return $this->belongsTo(IndonesiaProvince::class, 'province_code', 'code');
    }

    public function districts()
    {
        return $this->hasMany(IndonesiaDistrict::class, 'city_code', 'code');
    }

}
