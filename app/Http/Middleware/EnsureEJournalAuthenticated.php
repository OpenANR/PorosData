<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureEJournalAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session contains the authenticated E-Journal user ID
        if (!session()->has('ejournal_user_id')) {
            return redirect()->route('ejournal.login');
        }

        // Verify the user exists in database
        $user = User::find(session('ejournal_user_id'));
        if (!$user) {
            session()->forget('ejournal_user_id');
            return redirect()->route('ejournal.login');
        }

        // Share the user data globally in views as $ejournalUser
        view()->share('ejournalUser', $user);

        // Attach to the request object for controllers if needed
        $request->merge(['ejournalUser' => $user]);

        return $next($request);
    }
}
