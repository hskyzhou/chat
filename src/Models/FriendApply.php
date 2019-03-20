<?php

namespace HskyZhou\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class FriendApply extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'friend_id', 'is_agree', 'remark', 'content', 'friend_group_id'
    ];

    /**
     * 获取申请者信息
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    /**
     * 获取被添加好友信息
     * @return [type] [description]
     */
    public function friend()
    {
        return $this->hasOne(\App\User::class, 'id', 'friend_id');
    }
}
