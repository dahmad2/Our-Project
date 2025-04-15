<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Ensure user is logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // If user is admin, bypass the approval check
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Redirect non-approved users
        if (!$user->is_approved) {
            return redirect()->route('auth.pending');
        }

        return $next($request);
    }
}
