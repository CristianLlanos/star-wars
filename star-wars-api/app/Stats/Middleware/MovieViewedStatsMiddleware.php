<?php

namespace App\Stats\Middleware;

use App\Stats\Contracts\Analytics;
use App\Stats\Events\MovieViewed;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieViewedStatsMiddleware
{
    public function __construct(public Analytics $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $id = $request->route('id');

        if ($id === null) {
            return $response;
        }

        $this->analytics->track(new MovieViewed((string) $id));

        return $response;
    }
}
