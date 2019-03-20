<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use HskyZhou\Chat\Models\FriendApply;

class MsgboxController extends Controller
{
	use ValidatesRequests;

	public function index()
	{
		if (request()->ajax()) {
			$userId = auth()->user()->id;

			$friendApplys = FriendApply::with(['user', 'friend'])->where('user_id', $userId)->orWhere('friend_id', $userId)->paginate();

			return [
				'code' => 0,
				'pages' => $friendApplys->total(),
				'data' => $this->getFriendApplyData($friendApplys, $userId),
			];
		} else {
			return view('hskychat::msgbox.index')->with(compact('friendApplys'));
		}
	}

	protected function getFriendApplyData($list, $userId)
	{
		return $list->map(function ($item, $key) use ($userId) {
			return [
				'from' => $item->user_id,
				'from_group' => 0,
				'content' => $this->getFriendApplyDataOfContent($item, $userId),
				'time' => $item->created_at->toDateString(),
				'remark' => is_null($item->remark) ? '' : $item->remark,
				'is_action' => $item->is_agree == '3' && $item->friend_id == $userId,
				'user' => [
					'avatar' => $item->user->avatar,
					'username' => $item->user->name,

				],
			];
		});
	}

	private function getFriendApplyDataOfContent($info, $userId)
	{
		switch ($info->is_agree) {
			case '1':
				$content = $info->user_id == $userId ? sprintf("%s 已经同意你的好友申请", $info->friend->name) : sprintf("已同意 %s 的好友申请", $info->user->name);
				break;
			case '2':
				$content = $info->user_id == $userId ? sprintf("%s 已经拒绝你的好友申请", $info->friend->name) : sprintf("已拒绝 %s 的好友申请", $info->user->name);
				break;
			case '3':
				$content = $info->user_id == $userId ? sprintf("等待 %s 同意", $info->friend->name) : sprintf("%s 申请添加你为好友", $info->user->name);
				break;
			default:
				$content = '';
				break;
		}

		return $content;
	}
}