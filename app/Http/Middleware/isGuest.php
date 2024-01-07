<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() == false) {
            //kalau Auth sudah mendeteksi ada riwayat login, maka diperbolehkan akses rout terkait
            return $next($request);
        } else {
            //kalau gada, diarahkan ke halaman login balik
            return redirect('/dashboard')->with('failed', 'Anda sudah login!!');
        }
    }
}
