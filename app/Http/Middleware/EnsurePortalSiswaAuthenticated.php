<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsurePortalSiswaAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session contains the authenticated Portal Siswa user ID
        if (!session()->has('portalsiswa_user_id')) {
            return redirect()->route('portalsiswa.login');
        }

        // Verify the user exists in database and has the role 'siswa'
        $user = User::where('id', session('portalsiswa_user_id'))->where('role', 'siswa')->first();
        if (!$user) {
            session()->forget('portalsiswa_user_id');
            return redirect()->route('portalsiswa.login');
        }

        // Share the user data globally in views as $portalsiswaUser (including their student identity via relation)
        $user->load(['siswa.kelas']);
        view()->share('portalsiswaUser', $user);

        // Attach to the request object for controllers if needed
        $request->merge(['portalsiswaUser' => $user]);

        return $next($request);
    }
}
