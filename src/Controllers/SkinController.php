<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use HskyZhou\Chat\Exceptions\ChatErrorException;
use DB;

class SkinController extends Controller
{
	use ValidatesRequests;

    public function save()
    {
        $data = [
            'result' => true,
            'message' => '保存背景成功',
        ];

        DB::transaction(function () {
            $user = auth()->user();

            $user->init_skin = request('skin', '');
            if( !$user->save() ) {
                throw new ChatErrorException("切换皮肤失败");
            }
        });

        return response()->json($data);
    }
}