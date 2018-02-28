<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use HskyZhou\Chat\Models\Group;
use Exception;

class MemberController extends Controller
{
	use ValidatesRequests;

	public function index()
    {
    	$data = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'list' => [],
            ]
        ];

        try {
            $groupId = request('id', 0);

            $users = Group::find($groupId)->users;

            if( $users->isNotEmpty() ) {
                foreach( $users as $user ) {
                    $data['data']['list'][] = [
                        'username' => $user->name,
                        'id' => $user->id,
                        'avatar' => $user->avatar,
                        'sign' => $user->sign,
                    ];
                }
            }
        } catch (Exception $e) {
            dd($e);
        }

		return response()->json($data);	
    }
}