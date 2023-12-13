<?php

namespace App\Http\Controllers\Api\CustomUserAuthSystem;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;;

class ForgotPasswordController extends Controller
{
    public function sendForgotPasswordEmail(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email'
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
            if ($user) {
                $token = Password::createToken($user);
                // Send the email with the token
                $user->sendPasswordResetNotification($token);
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.SUCCESS_CODE'),
                    config('messages.PASSWORD_RESET_EMAIL_SUCCESS'),
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }

            throw ValidationException::withMessages([
                'error' => ['Invalid email.']
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

    public function verifyOtp(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'otp' => 'required|digits:4',
                'email' => 'required|email|exists:users,email'
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
            if ($user && Password::tokenExists($user, $req->otp)) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.SUCCESS_CODE'),
                    config('messages.OTP_VERIFICATION_SUCCESS'),
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }
    
            throw ValidationException::withMessages([
                'error' => ['Invalid OTP.'],
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
