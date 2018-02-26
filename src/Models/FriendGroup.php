<?php

namespace HskyZhou\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class FriendGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
