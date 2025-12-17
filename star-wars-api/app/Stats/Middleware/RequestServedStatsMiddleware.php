<?php

namespace App\Stats\Middleware;

use App\Stats\Contracts\Analytics;
use App\Stats\Events\RequestServed;
use App\Support\TimeTracker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestServedStatsMiddleware
{
    public function __construct(public Analytics $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $timer = TimeTracker::start();

        $response = $next($request);

        $member = $request->path();

        $this->analytics->track(new RequestServed(
            $member,
            [
                'request_time' => $timer->elapsed(),
                'method' => $request->method(),
                'status' => method_exists($response, 'status') ? $response->status() : null,
            ]
        ));

        return $response;
    }
}
