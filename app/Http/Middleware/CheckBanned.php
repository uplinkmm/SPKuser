<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_verified == 1) {
            if ($request->user()->currentAccessToken()) {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'You are banned. Token revoked.'], 403);
            } else {
                // SPA Mode (Session-Based)
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'You are banned. Please contact the administrator.');
            }
            // return redirect()->route('login')->with('error', 'You are banned. Please contact the administrator for more information.');
        }

        
        return $next($request);
    }
}
