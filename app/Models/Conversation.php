<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidRamsey;

class Conversation extends Model
{
    // urutan migration terkait chat - 1
    use HasFactory, HasUuidRamsey;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'type', // 'private', 'group', 'hotline'
        'status', // 'open', 'processing', 'resolved', 'archived'
        'hotline_type', // 'kelurahan', 'kecamatan', 'opd'
        'priority', // 'low', 'medium', 'high', 'critical'
        'case_number',
        'created_by',
        'last_message_id',
        'description',
        'is_private',
        'service_type',
        'subject',
        'recipient_type',
        'recipient_id',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->using(ConversationUser::class)
            ->withPivot(['role', 'unread_count', 'joined_at', 'muted_until'])
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pic()
    {
        return $this->participants()->wherePivot('role', 'pic');
    }

    public function scopeHotline($query)
    {
        return $query->where('type', 'hotline');
    }
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
    
}
