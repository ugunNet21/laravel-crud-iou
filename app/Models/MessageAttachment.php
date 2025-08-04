<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidRamsey;

class MessageAttachment extends Model
{
    // urutan migration terkait chat - 4

    use HasFactory, HasUuidRamsey;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'message_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'thumbnail_path',
        'original_name',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}