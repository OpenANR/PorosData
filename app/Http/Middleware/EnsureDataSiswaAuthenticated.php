<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureDataSiswaAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session contains the authenticated Data Siswa user ID
        if (!session()->has('datasiswa_user_id')) {
            return redirect()->route('datasiswa.login');
        }

        // Verify the user exists in database
        $user = User::find(session('datasiswa_user_id'));
        if (!$user) {
            session()->forget('datasiswa_user_id');
            return redirect()->route('datasiswa.login');
        }

        // Share the user data globally in views as $datasiswaUser
        view()->share('datasiswaUser', $user);

        // Attach to the request object for controllers if needed
        $request->merge(['datasiswaUser' => $user]);

        return $next($request);
    }
}
