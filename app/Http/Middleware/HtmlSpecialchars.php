<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HtmlSpecialchars
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Do not alter CV routes to avoid multi-encoding entities like &amp;amp;
        if ($request->is('user/cv*') || $request->is('*/cv*')) {
            return $next($request);
        }

        $input = array_filter($request->all());

        array_walk_recursive($input, function (&$input) {
            if (is_string($input)) {
                $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8', false);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
