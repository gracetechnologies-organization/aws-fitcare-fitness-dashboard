<?php

namespace App\Http\Controllers\Api\CustomUserAuthSystem;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => ['required', Password::min(8)],
                'role_id' => 'required|string'
            ]);
            if ($validator->fails()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    $validator->errors(),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }
            $data = User::insertInfo($req->name, $req->email, $req->password, $req->role_id);
            $data->token = $data->createToken('auth-token')->plainTextToken;
            return CustomResponseClass::JsonResponse(
                $data,
                config('messages.SUCCESS_CODE'),
                (empty($data)) ? config('messages.NO_RECORD') : '',
                config('messages.HTTP_SUCCESS_CODE')
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
