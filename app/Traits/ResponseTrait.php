<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    /**
     * Returns a success json message
     *
     * @param mixed $data
     * @param integer $code
     * @return JsonResponse
     */
    public function sendResponse($data, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * Returns an error json message
     *
     * @param mixed $data
     * @param integer $code
     * @return JsonResponse
     */
    public function sendError($data, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json($data, $code);
    }
}
