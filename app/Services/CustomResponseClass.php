<?php

namespace App\Services;

class CustomResponseClass
{
    public static function JsonResponse($data = [], $success = null, $message = '', $http_code = 500)
    {
        return response()->json([
            'data' => $data,
            'success' => $success,
            'message' => $message
        ], $http_code);
    }
}
