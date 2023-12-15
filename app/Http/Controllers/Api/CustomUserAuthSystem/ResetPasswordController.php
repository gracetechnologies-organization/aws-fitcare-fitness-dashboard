<?php

namespace App\Http\Controllers\Api\CustomUserAuthSystem;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|digits:4',
                'password' => ['required', 'confirmed', PasswordRules::min(8)]
            ]);
            if ($validator->fails()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    $validator->errors(),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }
            $user = User::getInfoByEmail($req->email);
            if (!Otp::verifyInfo($req->email, $req->otp)) {
                throw ValidationException::withMessages([
                    'error' => ['Sorry! We cannot reset the password because the OTP is invalid.']
                ]);
            }
            User::updatePassword($user->id, $req->password);
            Otp::deleteInfoByEmail($req->email);
            return CustomResponseClass::JsonResponse(
                [],
                config('messages.SUCCESS_CODE'),
                config('messages.PASSWORD_RESET_SUCCESS'),
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
