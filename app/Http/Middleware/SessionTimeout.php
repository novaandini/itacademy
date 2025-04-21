<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and the session has expired
        if (Auth::check() && $request->session()->has('last_activity')) {
            $lastActivity = $request->session()->get('last_activity');
            $timeout = config('session.lifetime') * 900; // Convert minutes to seconds
            
            if (time() - $lastActivity > $timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }
        }
        
        // Update last activity time
        $request->session()->put('last_activity', time());
        
        return $next($request);
    }
}

