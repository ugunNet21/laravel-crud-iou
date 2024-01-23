<?php

namespace App\Models\Alamat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'kecamatan_id'];
    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class);
    }
}
