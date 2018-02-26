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
	    	if( $userFriends->isNotEmpty() ) {
	    		foreach( $userFriends as $userFriend ) {
	    			$friendGroupId = $userFriend->pivot->friend_group_id;
	    			if( !isset($friends[$friendGroupId]) ) {
	    				$friends[$friendGroupId]['id'] = $friendGroupId;
	    				$friends[$friendGroupId]['groupname'] = $friendGroupId;
	    			}
	    			/*朋友信息*/
					$friends[$friendGroupId]['list'][] = $this->userShowInfo($userFriend);;
	    		}
	    	}

            /*用户组*/
            $userGroups = $user->groups;
            if( $userGroups->isNotEmpty() ) {
                foreach( $userGroups as $userGroup ) {
                    $groups[] = $this->groupShowInfo($userGroup);
                }
            }

	    	$mine = $this->userShowInfo($user);
    	} else {
    		$mine = User::make([
    			'name' => '<a href="">请先登录</>',
    			'email' => '',
    		]);
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
    		'avatar' => $user->id,
    		'sign' => $user->email,
    		'status' => "online"
    	];
    }

    private function groupShowInfo($group)
    {
        return [
            "groupname" => $group->name,
            "id" => $group->id,
            "avatar" => $group->id,
        ];
    }
}