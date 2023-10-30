<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EmployeeActivationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role_id == 'emp' && is_null(Auth::user()->email_verified_at)) {
            auth()->logout();
            throw ValidationException::withMessages([
                'blocked' => 'Sorry! You are blocked by the admin.',
                'solution' => 'To proceed request the admin to activate your account.',
            ]);
        }
        return $next($request);
    }
}