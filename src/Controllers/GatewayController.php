<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use GatewayClient\Gateway;

class GatewayController extends Controller
{
	use ValidatesRequests;

	public function __construct()
	{
		Gateway::$registerAddress = config('chat.address');
	}

	/**
	 * 绑定
	 * @return [type] [description]
	 */
    public function bind()
    {
    	/*当前登录用户id*/
    	$user = auth()->user();
    	$uid = $user->id;

    	/*socket的客户id*/
    	$clientId = request('client_id', '');

    	/*绑定uid和客户id*/
    	if( Gateway::bindUid($clientId, $uid) ) {
    		/*绑定组*/
    		$data = [
    			'result' => true,
    			'message' => '绑定成功'
    		];
    	} else {
    		$data = [
    			'result' => true,
    			'message' => '绑定失败'
    		];
    	}

    	return response()->json($data);
    }

    public function send()
    {
    	/*发送的消息*/
    	$data = request('data');

    	$type = $data['to']['type'];

    	/*聊天消息*/
  		$sendData = [
  			'username' => $data['mine']['username'],
  			'avatar' => $data['mine']['avatar'],
  			'id' => $data['mine']['id'],
  			'type' => $data['to']['type'],
  			'content' => $data['mine']['content'],
  			'cid' => 0,
  			'mine' => false,
  			'fromid' => $data['mine']['id'],
  			'timestamp' => time() * 1000,
  			'emit' => 'message',
  		];

  		$sendContent = json_encode($sendData);

  		/*接受的id*/
		$toId = $data['to']['uid'];

    	switch( $type ) {
    		case 'friend' :
		    	GateWay::sendToUid($toUid, $sendContent);
    			break;
    		case 'group' :
		    	GateWay::sendToGroup($toId, $sendContent);
    			break;
    	}

    	$data = [
  			'result' => true,
  			'message' => '发送成功'
  		];

        return response()->json($data);
    }
}