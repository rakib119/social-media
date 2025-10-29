<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class RoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        try {
            $permissions_array = session('permission_route', []);
            $currentRoute = Route::currentRouteName();

            if ($currentRoute === 'home') {
                return $next($request);
            }

            if (!isset($permissions_array[$currentRoute])) {
                return redirect()->route('home');
            }

            return $next($request);
        } catch (\Exception $e) {
            \Log::error('Middleware exception: ' . $e->getMessage());
            return redirect()->route('home');
        }
    }
}
