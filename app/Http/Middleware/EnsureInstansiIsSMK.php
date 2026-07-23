<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Instansi;

class EnsureInstansiIsSMK
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $instansi = Instansi::first();

        // Jika tidak ada instansi atau instansi bukan SMK, batalkan request
        if (!$instansi || $instansi->tingkat !== 'SMK') {
            return redirect()->route('dashboard')->with('error', 'Akses ke Portal PKL ditolak. Aplikasi tidak dikonfigurasi untuk Instansi SMK.');
        }

        return $next($request);
    }
}
