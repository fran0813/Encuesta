<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // return redirect('/home');
            // Logic that determines where to send the user
            if($request->user()->hasRole('user')){
            return redirect('/user/');
            }
            if($request->user()->hasRole('admin')){
            return redirect('/admin/');
            }
        }

        return $next($request);
    }
}
