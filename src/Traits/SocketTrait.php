<?php 

namespace HskyZhou\Chat\Traits;

use GatewayClient\Gateway;

Trait SocketTrait
{
	public function notifyOne($toId, $data)
    {
        Gateway::$registerAddress = config('chat.register_address');

        GateWay::sendToUid($toId, json_encode($data));
    }

    /**
     * 通知添加好友到面板
     * @return [type] [description]
     */
    public function notifyAddList($toId, $groupId, $friend)
    {
        $data = [
            'emit' => 'addList',
            'type' => 'friend',
            'avatar' => $friend->avatar,
            'username' => $friend->name,
            'group' => $groupId,
            'uid' => $friend->id,
            'sign' => $friend->sign,
        ];
        $this->notifyOne($toId, $data);
    }
}