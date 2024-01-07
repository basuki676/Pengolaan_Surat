<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            // kalau Auth sudah mendeteksi ada riwayat login, maka diperbolehkan akses route terkait
            return $next($request);
        } else {
            // kalau tidak ada, diarahkan ke halaman login balik
            return redirect()->route('login')->with('failed', 'Anda belum login!');
        }
    }
}
