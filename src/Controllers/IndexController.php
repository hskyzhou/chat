<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;

class IndexController extends Controller
{
	use ValidatesRequests;

	public function index()
    {
    	/*当前用户*/
    	$user = auth()->user();

    	/*个人信息*/
    	$mine = [];
    	/*朋友信息*/
    	$friends = [];
        /*参与的组*/
        $groups = [];

    	if( $user ) {
            /*用户朋友*/
	    	$userFriends = $user->friends;
            /*朋友群组*/
            $friendGroups = $user->friendGroups->keyBy('id');

            if ($friendGroups->isNotEmpty()) {
                foreach ($friendGroups as $friendGroup) {
                    $friends[$friendGroup->id]['id'] = $friendGroup->id;
                    $friends[$friendGroup->id]['groupname'] = $friendGroup->name;
                    $friends[$friendGroup->id]['list'] = [];
                }
            }

	    	if( $userFriends->isNotEmpty() ) {
	    		foreach( $userFriends as $userFriend ) {
	    			$friendGroupId = $userFriend->pivot->friend_group_id;

                    $friendGroup = $friendGroups->get($friendGroupId);

	    			if ($friendGroup) {
	    				$friends[$friendGroupId]['id'] = $friendGroupId;
	    				$friends[$friendGroupId]['groupname'] = $friendGroup->name;
	    			}
	    			/*朋友信息*/
					$friends[$friendGroupId]['list'][] = $this->userShowInfo($userFriend);;
	    		}
	    	}

            $friends = array_values($friends);

            /*用户组*/
            $groups = [];

	    	$mine = $this->userShowInfo($user);
    	} else {
    		$mine = User::make([]);
            $mine->username = '<a href="'.route('login').'">请先登录</a>';
    	}

    	$data = [
			'code' => 0,
			'msg' => "",
			'data' => [
				'mine' => $mine,
				'friend' => $friends,
                'group' => $groups,
			]
		];

		return response()->json($data);	
    }

    private function userShowInfo($user)
    {
    	return [
    		'username' => $user->name,
    		'id' => isset($user->id) ? $user->id : 0,
    		'avatar' => $user->avatar,
    		'sign' => $user->sign,
    		'status' => "online"
    	];
    }

    private function groupShowInfo($group)
    {
        return [
            "groupname" => $group->name,
            "id" => $group->id,
            "avatar" => $group->avatar,
        ];
    }
}