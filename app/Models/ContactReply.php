<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $fillable = [
        'contact_id',
        'user_id',
        'reply_subject',
        'reply_message',
    ];
}
