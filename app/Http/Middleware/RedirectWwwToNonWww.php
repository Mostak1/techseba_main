<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectWwwToNonWww
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $canonicalHost = config('techseba_seo.canonical_host', 'techseba.com');

        if ($host === 'www.' . $canonicalHost) {
            return redirect()->away('https://' . $canonicalHost . $request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
