<?php

namespace HskyZhou\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function users()
    {
    	return $this->belongsToMany(\App\User::class, 'user_groups', 'group_id', 'user_id');
    }

    public function chatlogs()
    {
        return $this->hasMany(ChatLog::class, 'type_id', 'id')->where('type', 'group');
    }
}
