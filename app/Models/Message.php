<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['name', 'email', 'message', 'status', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
