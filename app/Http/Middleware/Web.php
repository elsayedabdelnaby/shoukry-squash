<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class Web
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = Setting::find(1);
        View::share('general_settings', [
            'phone_number' => $settings->phone_number,
            'instagram_page' => $settings->instagram_page,
            'facebook_page' => $settings->facebook_page,
            'session_duration' => $settings->session_duration,
            'members_count' => $settings->members_count,
            'experience_years' => $settings->experience_years,
        ]);
        return $next($request);
    }
}
