<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsBanned
{
    public function handle(Request $request, Closure $next): Response
        {
            if (auth()->check() && !auth()->user()->is_active) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
    
                return redirect()->route('login')
                    ->with('status', 'Your account has been banned by Admin. Please contact support.');
            }
    
            return $next($request);
        }
}