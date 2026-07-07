<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Jika user sudah login dan mencoba akses login/register,
     * arahkan ke halaman sesuai role-nya.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index');
            }
            if ($user->role === 'jastiper') {
                return redirect()->route('jastiper.dashboard.index');
            }

            return redirect()->route('home');
        }

        return $next($request);
    }
}
