<?php 

namespace HskyZhou\Chat\Traits;

use HskyZhou\Chat\Exceptions\ChatErrorException;

Trait ExceptionTrait
{
	public function handleChatException($e)
    {
        if ($e instanceof ChatErrorException) {
            return response()->json([
                'code' => 0,
                'message' => $e->getMessage(),
                'data' => [],
            ]);
        }
    }
}