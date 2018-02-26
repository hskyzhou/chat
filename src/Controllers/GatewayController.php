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

    public function send()
    {
    	/*发送的消息*/
    	$data = request('data');

    	$type = $data['to']['type'];

    	/*聊天消息*/
  		$sendData = [
  			'username' => $data['mine']['username'],
  			'avatar' => $data['mine']['avatar'],
  			'type' => $data['to']['type'],
  			'content' => $data['mine']['content'],
  			'cid' => 0,
  			'mine' => false,
  			'fromid' => $data['mine']['id'],
  			'timestamp' => time() * 1000,
  			'emit' => 'message',
  		];


        /*接受的id*/
        $toId = $data['to']['id'];

        switch( $type ) {
            case 'friend' :
                $sendData = array_merge($sendData, [
                    'id' => $data['mine']['id'],
                ]);
          		$sendContent = json_encode($sendData);
		    	GateWay::sendToUid($toId, $sendContent);
    			break;
    		case 'group' :
                $sendData = array_merge($sendData, [
                  'id' => $data['to']['id'],
                ]);
                $sendContent = json_encode($sendData);
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