<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user adalah admin
        $user = Auth::user();
        if (!$user->is_admin) {
            return redirect('/')->with('error', 'Akses ditolak - hanya admin');
        }

        return $next($request);
    }
}
