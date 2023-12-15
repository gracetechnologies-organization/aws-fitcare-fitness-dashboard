<?php

namespace App\Http\Controllers;

use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $req)
    {
        try {
            if ($req->user()->tokens()->delete()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.SUCCESS_CODE'),
                    'Logout successful',
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }
            return CustomResponseClass::JsonResponse(
                [],
                config('messages.ERROR_CODE'),
                'Unable to logout',
                config('messages.HTTP_UNAUTHORIZED_CODE')
            );
        } catch (Exception $error) {
            report($error);
            return CustomResponseClass::JsonResponse(
                [],
                config('messages.FAILED_CODE'),
                $error->getMessage(),
                config('messages.HTTP_SERVER_ERROR_CODE')
            );
        }
    }
}
