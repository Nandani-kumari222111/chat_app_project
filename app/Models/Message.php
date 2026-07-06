<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Conversation;
use App\Models\User;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'message_type',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}