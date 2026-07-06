<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\User;

class Conversation extends Model
{
    protected $fillable = [];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}