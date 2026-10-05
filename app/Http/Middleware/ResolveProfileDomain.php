<?php

namespace App\Http\Middleware;

use App\Models\ProfileDomain;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ResolveProfileDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = strtolower($request->getHost());
        $mainDomain = strtolower(parse_url(config('app.url'), PHP_URL_HOST) ?: 'techseba.com');
        $canonicalHost = strtolower(config('techseba_seo.canonical_host', 'techseba.com'));

        $mainHosts = array_unique(array_filter([
            $mainDomain,
            'www.' . $mainDomain,
            $canonicalHost,
            'www.' . $canonicalHost,
            'localhost',
            '127.0.0.1',
        ]));

        if (in_array($host, $mainHosts, true)) {
            return $next($request);
        }

        $profileDomain = ProfileDomain::with(['user', 'user.userCv'])
            ->where('host', $host)
            ->where('is_active', true)
            ->first();

        if (! $profileDomain) {
            abort(404);
        }

        $request->attributes->set('profileDomain', $profileDomain);
        $request->attributes->set('profileUser', $profileDomain->user);

        View::share('profileDomain', $profileDomain);
        View::share('profileUser', $profileDomain->user);

        return $next($request);
    }
}
