<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class CheckIfUserBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_banned) {
            // Jika pengguna dibanned, logout mereka dan arahkan ke halaman login dengan pesan error
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                'email' => 'Akun Anda telah dibanned.',
            ]);
        }

        return $next($request);
    }
}