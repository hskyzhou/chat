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

    	if( $user ) {

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
				'friend' => $friends
			]
		];

		return response()->json($data);	
    }

    private function userShowInfo($user)
    {
    	return [
    		'username' => $user->name,
    		'id' => isset($user->id) ? $user->id : 0,
    		'avatar' => "//tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg",
    		'sign' => $user->email,
    		'status' => "online"
    	];
    }
}