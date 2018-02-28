<?php 

namespace HskyZhou\Chat\Traits;

Trait UserTrait
{
	public function friends()
    {
        return $this->belongsToMany(\App\User::class, 'user_friend_groups', 'user_id', 'friend_user_id')->withPivot('friend_group_id');
    }

    public function groups()
    {
        return $this->belongsToMany(\HskyZhou\Chat\Models\Group::class, 'user_groups', 'user_id', 'group_id');
    }
}