<?php

namespace App\Stats\Middleware;

use App\Stats\Contracts\Analytics;
use App\Stats\Events\MoviesQueried;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoviesQueriedStatsMiddleware
{
    public function __construct(public Analytics $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $title = $request->query('title');

        if ($title === null) {
            return $response;
        }

        $this->analytics->track(new MoviesQueried($title));

        return $response;
    }
}
