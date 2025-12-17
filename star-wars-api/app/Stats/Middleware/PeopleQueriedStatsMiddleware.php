<?php

namespace App\Stats\Middleware;

use App\Stats\Contracts\Analytics;
use App\Stats\Events\PeopleQueried;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeopleQueriedStatsMiddleware
{
    public function __construct(public Analytics $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $name = $request->query('name');

        if ($name === null) {
            return $response;
        }

        $this->analytics->track(new PeopleQueried($name));

        return $response;
    }
}
