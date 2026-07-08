<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsurePortalNilaiAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session contains the authenticated Portal Nilai user ID
        if (!session()->has('portalnilai_user_id')) {
            return redirect()->route('portalnilai.login');
        }

        $userId = session('portalnilai_user_id');

        // Check if it is the dummy administrator session
        if ($userId === 'dummy_admin') {
            $user = new User();
            $user->id = 999999; // Mock ID
            $user->name = 'Administrator Dummy';
            $user->username = 'admin_nilai';
            $user->role = 'admin';
        } else {
            // Verify the user exists in database
            $user = User::find($userId);
            if (!$user) {
                session()->forget('portalnilai_user_id');
                return redirect()->route('portalnilai.login');
            }
        }

        // Share the user data globally in views as $portalnilaiUser
        view()->share('portalnilaiUser', $user);

        // Attach to the request object for controllers if needed
        $request->merge(['portalnilaiUser' => $user]);

        return $next($request);
    }
}
