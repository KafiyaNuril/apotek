<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // untuk mengecek apakah user yang login adalah admin
        if(Auth::user()->role == "admin"){
            // return $next($request) => artinya lanjutkan ke middleware selanjutnya
            return $next($request);
        }

        return redirect()->route('home')->with('failed', 'Tidak memiliki akses');
    }
}
