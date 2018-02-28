<?php

namespace HskyZhou\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'type_id', 'from_id', 'content', 'created_at', 'updated_at',
    ];

    public function user()
    {
    	return $this->hasOne(\App\User::class, 'id', 'from_id');
    }
}
