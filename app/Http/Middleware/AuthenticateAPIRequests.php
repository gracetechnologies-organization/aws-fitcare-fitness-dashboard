<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;

class AuthenticateAPIRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request,  Closure $next)
    {
        try {
            if ($request->cat_id && $request->header('token')) {
                if ($request->header('token') === Category::find($request->cat_id)->token) {
                    return $next($request);
                } else {
                    return CustomResponseClass::JsonResponse(
                        [],
                        config('messages.FAILED_CODE'),
                        config('messages.TOKEN_INVALID'),
                        config('messages.HTTP_INVALID_TOKEN')
                    );
                }
            } else {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    config('messages.PARAM_MISSING'),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }
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
