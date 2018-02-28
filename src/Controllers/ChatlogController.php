<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use HskyZhou\Chat\Models\Group;
use Exception;
use HskyZhou\Chat\Models\ChatLog;

class ChatlogController extends Controller
{
	use ValidatesRequests;

	public function index()
    {
        /*获取friend_id,或者group_id*/
        $id = request('id', '');
        /*获取类型，friend或者group*/
        $type = request('type', 'friend');

        $curId = auth()->user()->id;

        if( request()->ajax() ) {


            $perPage = 8;

            if ( $type == 'friend' ) {
                $list = ChatLog::with('user')
                            ->where('type', $type)
                            ->where(function($query) use ($id, $curId) {
                                $query->where('type_id', $id)->where('from_id', $curId);
                            })
                            ->orWhere( function($query) use ($id, $curId) {
                                $query->where('type_id', $curId)->where('from_id', $id);
                            })
                            ->paginate($perPage);
                $count = ChatLog::with('user')
                            ->where('type', $type)
                            ->where(function($query) use ($id, $curId) {
                                $query->where('type_id', $id)->where('from_id', $curId);
                            })
                            ->orWhere( function($query) use ($id, $curId) {
                                $query->where('type_id', $curId)->where('from_id', $id);
                            })
                            ->count();
            } else {
                $list = ChatLog::with('user')
                            ->where('type', $type)
                            ->where('type_id', $id)
                            ->paginate($perPage);

                $count = ChatLog::with('user')
                            ->where('type', $type)
                            ->where('type_id', $id)
                            ->count();
            }

            $list = $list->map(function($item, $key) {
                return [
                    'avatar' => $item->user->avatar,
                    'created_at' => $item->created_at->format('Y-m-d h:i:s'),
                    'content' => $item->content,
                    'name' => $item->user->name,
                    'from_id' => $item->from_id,
                ];
            });

            $results = [
                'data' => $list,
                'pages' => ceil($count / $perPage),
            ];
           
            return response()->json($results);
        } else {
            $results = [
                'id' => $id,
                'type' => $type,
                'curId' => $curId,
            ];
            return view("hskychat::chatlog.index")->with($results);
        }
    }
}