<?php

namespace App\Http\Controllers;

use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function destroy()
    {
        try {
            $destroyed = Cache::flush();
            return CustomResponseClass::JsonResponse(
                [],
                ($destroyed) ? config('messages.SUCCESS_CODE') : config('messages.FAILED_CODE'),
                ($destroyed) ? config('messages.CACHE_DESTROYED_SUCCESS') : config('messages.CACHE_DESTROYED_FAILED'),
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
