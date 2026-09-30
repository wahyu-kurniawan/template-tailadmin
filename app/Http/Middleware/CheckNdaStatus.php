<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckNdaStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        if ($user && $user->status !== 'active') {
            if (!$request->routeIs('nda.*') && !$request->routeIs('logout')) {
                return redirect()->route('nda.form');
            }
        }

        return $next($request);
    }
}
