<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     * Redirect ke login jika belum terautentikasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            // Jika request mengharapkan JSON (API), kembalikan 401
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
