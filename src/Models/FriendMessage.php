<?php

namespace HskyZhou\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class FriendMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'friend_id', 'content', 'is_read'
    ];
}
