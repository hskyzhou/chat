<?php 

namespace HskyZhou\Chat\Traits;

Trait ChatUserTrait
{
	public function friends()
    {
        return $this->belongsToMany(\App\User::class, 'friends', 'user_id', 'friend_id')->withPivot('friend_group_id');
    }

    public function groups()
    {
        return $this->belongsToMany(\HskyZhou\Chat\Models\Group::class, 'user_groups', 'user_id', 'group_id');
    }

    /**
     * 朋友分组
     * @return [type] [description]
     */
    public function friendGroups()
    {
        return $this->hasMany(\HskyZhou\Chat\Models\FriendGroup::class, 'user_id', 'id');
    }

    /**
     * 绑定好友
     * @return [type] [description]
     */
    public function bindFriend($friendId, $friendGroupId)
    {
    	$this->friends()->attach($friendId, [
    		'friend_group_id' => $friendGroupId
    	]);
    }
}