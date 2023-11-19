<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetSessionLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there is a locale in the session
        $locale = $request->session()->get('locale');

        // If there is no locale in the session, use the default locale from configuration
        if (!$locale) {
            $locale = config('app.locale');
            session(['locale' => $locale]);
        }

        // Set the locale for the application
        App::setLocale($locale);        
        
        return $next($request);
    }
}
