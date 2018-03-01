<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use Exception;

class SkinController extends Controller
{
	use ValidatesRequests;

    public function save()
    {
        $data = [
            'result' => false,
            'message' => '保存背景失败',
        ];

        try {
            $user = auth()->user();

            $user->init_skin = request('skin', '');
            if( $user->save() ) {
                $data = [
                    'result' => true,
                    'message' => '保存背景成功',
                ];
            }
        } catch (Exception $e) {
            
        }

        return response()->json($data);
    }
}