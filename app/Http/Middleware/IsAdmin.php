<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (!auth()->check()) {
            return redirect('dashboard/login');
        }

        $user = auth()->user();
        if (in_array($user->type, ['admin'])) {
            return $next($request);
        }

        auth()->logout();
        return redirect('/dashboard/login')->with('error', __('dashboard.you_must_be_logged_in_as_admin'));
    }
}
