<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use Exception;
use GatewayClient\Gateway;

class InitController extends Controller
{
	use ValidatesRequests;

	public function index()
    {
        try {
            $user = auth()->user();

            if( $user ) {
                /*绑定用户id和cliend_id*/
                $this->bind($user);

                /*用户初始化已加入的组*/
                $this->join($user, $clientId);
            } else {
                throw new Exception("请先登录", 2);
            }
        } catch (Exception $e) {
            
        }
    }

    /**
     * 绑定
     * @return [type] [description]
     */
    private function bind($user)
    {
        $uid = $user->id;

        /*socket的客户id*/
        $clientId = request('client_id', '');

        /*绑定uid和客户id*/
        if( Gateway::bindUid($clientId, $uid) ) {
            return true;
        } else {
            throw new Exception("绑定失败", 2);
        }
    }

    /**
     * 初始化用户加入组
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    private function join($user, $clientId)
    {
        $groups = $user->groups;

        if( $groups->isNotEmpty() ) {
            foreach( $groups as $group ) {
                Gateway::joinGroup($clientId, $group->id);
            }
        }
    }
}