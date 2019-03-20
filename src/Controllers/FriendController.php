<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use HskyZhou\Chat\Models\FriendApply;
use HskyZhou\Chat\Models\Friend;
use DB;
use HskyZhou\Chat\Exceptions\ChatErrorException;
use HskyZhou\Chat\Traits\SocketTrait;

class FriendController extends Controller
{
	use ValidatesRequests;
	use SocketTrait;
	
	/**
	 * 申请添加好友
	 * @return [type] [description]
	 */
	public function apply()
	{
		DB::transaction(function () {
			$userId = auth()->user()->id;
			/*添加好友申请*/
			$requestData = request()->only(['friend_id', 'remark']);
			$requestData['user_id'] = $userId;
			$requestData['friend_group_id'] = request('group');

			if ($userId == request('friend_id')) {
				throw new ChatErrorException("不能请求加自己为好友");
			}

			/*查找*/
			if ($existFriendApply = FriendApply::where('user_id', $userId)->where('friend_id', request('friend_id'))->where('is_agree', 3)->first()) {
				if (request('remark')) {
					$existFriendApply->remark = request('remark');
					$existFriendApply->save();
				} else {
					throw new ChatErrorException("请等待对方确认");
				}
			} else {
				if (!FriendApply::create($requestData)) {
					throw new ChatErrorException("申请失败");
				}
			}

		});
		
		return response()->json([
			'code' => '200',
			'message' => '申请成功',
			'data' => [],
		]);		
	}

	/**
	 * 同意好友申请
	 * @return [type] [description]
	 */
	public function agree()
	{
		DB::transaction(function () {
			$userId = auth()->user()->id;
			$uid = request('uid');
			$friend = User::find($uid);

			$friendApplyInfo = FriendApply::where('user_id', $uid)->where('friend_id', $userId)->where('is_agree', 3)->first();

			if ($friendApplyInfo) {
				$friendApplyInfo->is_agree = 1;
				$friendApplyInfo->save();

				$friendData = [
					'user_id' => $userId,
					'friend_id' => $uid,
					'friend_group_id' => request('group'),
				];
				if (!Friend::create($friendData)) {
					throw new ChatErrorException("操作失败");
				}

				$userFriendData = [
					'user_id' => $uid,
					'friend_id' => $userId,
					'friend_group_id' => $friendApplyInfo->friend_group_id,
				];
				if (!Friend::create($userFriendData)) {
					throw new ChatErrorException("操作失败");
				}

				/*发送socket消息*/
				$this->notifyAddList($userId, request('group'), $friend); //同意者
				$this->notifyAddList($uid, $friendApplyInfo->friend_group_id, auth()->user()); //申请者
			} else {
				throw new ChatErrorException("请让对方重新申请加好友");
			}
		});

		return response()->json([
			'code' => '200',
			'message' => '操作成功',
			'data' => [],
		]);		
	}

	/**
	 * 拒绝好友申请
	 * @return [type] [description]
	 */
	public function reject()
	{

	}


}