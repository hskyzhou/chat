<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use GatewayClient\Gateway;
use HskyZhou\Chat\Models\FriendMessage;

class GatewayController extends Controller
{
	use ValidatesRequests;

	public function __construct()
	{
		Gateway::$registerAddress = config('chat.register_address');
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

        /*存入数据库*/
        $chatlogData = [
            'type' => $type,
            'friend_id' => $toId,
            'user_id' => $data['mine']['id'],
            'content' => $data['mine']['content'],
        ];

        if( FriendMessage::create($chatlogData) ) {
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
        } else {
            $data = [
                'result' => false,
                'message' => '发送失败'
            ];
        }


        return response()->json($data);
    }
}