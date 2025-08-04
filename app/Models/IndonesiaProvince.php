<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndonesiaProvince extends Model
{
    use HasFactory;
    protected $table = 'indonesia_provinces'; // sesuai prefix Laravolt

    public function cities()
    {
        return $this->hasMany(IndonesiaCity::class, 'province_code', 'code');
    }
}
