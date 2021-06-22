<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

trait ApiResponder
{
    /**
     * Build success response
     * @param string|array $data
     * @param string $description
     * @param int $code
     * @return Response|ResponseFactory
     */
    public static function success(
        $data,
        string $description = DEFAULT_RESPONSE_DESCRIPTION,
        int $code = Response::HTTP_OK
    ): Response {
        return response([
            'code' => $code,
            'message' => strtoupper(Response::$statusTexts[$code]),
            'description' => $description,
            'data' => $data,
        ], $code)->header('Content-Type', 'application/json');
    }

    /**
     * Build error responses
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public static function error(
        $data,
        int $code = Response::HTTP_FORBIDDEN
    ): JsonResponse {
        return response()->json([
            'code' => $code,
            'message' => strtoupper(Response::$statusTexts[$code]),
            'errors' => (is_array($data)) ? $data : ((!is_array($data) ? $data : []))
        ], $code)->header('Content-Type', 'application/json');
    }
}
