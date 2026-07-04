<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsurePortalPKLAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session contains the authenticated Portal PKL user ID
        if (!session()->has('portalpkl_user_id')) {
            return redirect()->route('portalpkl.login');
        }

        // Verify the user exists in database
        $user = User::find(session('portalpkl_user_id'));
        if (!$user) {
            session()->forget('portalpkl_user_id');
            return redirect()->route('portalpkl.login');
        }

        // Share the user data globally in views as $portalpklUser
        view()->share('portalpklUser', $user);

        // Attach to the request object for controllers if needed
        $request->merge(['portalpklUser' => $user]);

        return $next($request);
    }
}
