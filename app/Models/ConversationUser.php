<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ConversationUser extends Pivot
{
    // urutan migration terkait chat - 3

    protected $table = 'conversation_user';

    protected $casts = [
        'joined_at' => 'datetime',
        'muted_until' => 'datetime',
    ];

    protected $fillable = [
        'conversation_id',
        'user_id',
        'role', // 'Member', 'Admin', 'PIC'
        'unread_count',
        'joined_at',
        'muted_until',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}