<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('web')->check()) {
            return redirect()->route('user.login');
        }

        $profileUser = $request->attributes->get('profileUser');

        if (! $profileUser) {
            abort(404, 'Profile context not found.');
        }

        if ((int) Auth::guard('web')->id() !== (int) $profileUser->id) {
            abort(403, 'Unauthorized profile access.');
        }

        return $next($request);
    }
}
