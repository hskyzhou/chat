<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use Exception;

class SignController extends Controller
{
	use ValidatesRequests;

    public function save()
    {
        $data = [
            'result' => false,
            'message' => '签名保存失败',
        ];

        try {
            $user = auth()->user();

            $user->sign = request('sign', '');
            if( $user->save() ) {
                $data = [
                    'result' => true,
                    'message' => '签名保存成功',
                ];
            }
        } catch (Exception $e) {
            
        }

        return response()->json($data);
    }
}