<?php

namespace App\Services;

final class CustomResponseClass
{
    public static function JsonResponse($data = [], $success = null, $message = '', $http_code = 500)
    {
        return response()->json([
            'data' => $data,
            'success' => $success,
            'message' => $message
        ], $http_code);
    }

    public static function JsonResponseExtention($data = [], $success = null, $message = '', $extention_key, $extention_value, $http_code = 500)
    {
        return response()->json([
            'data' => $data,
            'success' => $success,
            'message' => $message,
            $extention_key => $extention_value
        ], $http_code);
    }
}
