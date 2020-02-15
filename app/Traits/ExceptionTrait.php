<?php


namespace App\Traits;


namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ExceptionTrait
{
    /**
     * @param string $exceptionMessage
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiException(string $exceptionMessage, $code)
    {
        Log::error($exceptionMessage);
        return response()->json(['error' => $exceptionMessage], $code);
    }
}

