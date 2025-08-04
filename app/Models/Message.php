<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidRamsey;

class Message extends Model
{
    // urutan migration terkait chat - 2

    use HasFactory, HasUuidRamsey;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'type', // 'text', 'image', 'file', 'system', 'notification'
        'status', // 'sent', 'delivered', 'read'
        'metadata',
        'parent_id',
    ];

    protected $casts = [
        'metadata' => 'array',
        'read_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class);
    }

    public function readStatuses()
    {
        return $this->hasMany(MessageReadStatus::class);
    }
}