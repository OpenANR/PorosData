<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Instansi;
use Illuminate\Support\Facades\Auth;

class CheckInstansiSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika instansi sudah ada, abaikan pengecekan
        if (Instansi::count() > 0) {
            return $next($request);
        }

        // Rute yang diizinkan saat aplikasi belum disetup
        $allowedRoutes = ['login', 'logout', 'instance-setup.form', 'instance-setup.process'];
        $currentRouteName = $request->route() ? $request->route()->getName() : null;

        if (in_array($currentRouteName, $allowedRoutes) || $request->is('login') || $request->is('logout') || $request->is('instance-setup')) {
            // Jika mengakses setup, pastikan dia superadmin
            if ($request->is('instance-setup') && Auth::check() && Auth::user()->role !== 'superadmin') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Hanya superadmin yang dapat melakukan setup instansi.');
            }
            return $next($request);
        }

        // Jika belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Aplikasi belum dikonfigurasi. Silakan login sebagai Superadmin.');
        }

        // Jika sudah login tapi bukan superadmin, logout
        if (Auth::user()->role !== 'superadmin') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Aplikasi dalam tahap setup. Akses ditolak.');
        }

        // Jika superadmin mencoba akses halaman lain, paksa ke setup
        return redirect()->route('instance-setup.form')->with('warning', 'Harap selesaikan konfigurasi instansi terlebih dahulu.');
    }
}
