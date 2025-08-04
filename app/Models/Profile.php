<?php

namespace App\Models;

use App\Traits\HasUuidRamsey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory, HasUuidRamsey;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'user_id',
        'phone',
        'address',
        'gender',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
