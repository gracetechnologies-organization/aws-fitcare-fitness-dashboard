<?php

namespace App\Http\Controllers\Api\CustomUserAuthSystem;

use App\Http\Controllers\Controller;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    $validator->errors(),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }

            if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
                $data = Auth::user();
                $data->token = $data->createToken('auth-token')->plainTextToken;
                return CustomResponseClass::JsonResponse(
                    $data,
                    config('messages.SUCCESS_CODE'),
                    '',
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }

            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.'],
            ]);
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
