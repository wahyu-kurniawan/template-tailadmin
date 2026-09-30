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

        // Admin selalu bebas masuk
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Jika user belum aktif, arahkan ke halaman khusus NDA
        if ($user && $user->status !== 'active') {
            // Hindari redirect loop jika sudah berada di halaman NDA atau proses logout
            if (!$request->routeIs('nda.*') && !-$request->routeIs('logout')) {
                return redirect()->route('nda.form');
            }
        }

        return $next($request);
    }
}
