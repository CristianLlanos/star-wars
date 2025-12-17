<?php

use App\Stats\Actions\GetStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeAverageRequestTimingStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopMovieQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopPersonQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\MostPopularHourOfDayStatsAction;
use Illuminate\Support\Facades\Cache;

it('returns empty when cache has no stats', function () {
    Cache::flush();

    $action = app(GetStatsAction::class);

    expect($action->execute())->toBe([]);
});

it('returns only available cached sections', function () {
    Cache::flush();

    Cache::put(ComputeTopMovieQueriesStatsAction::CACHE_KEY, ['a new hope' => 60.0]);
    Cache::put(ComputeTopPersonQueriesStatsAction::CACHE_KEY, ['luke' => 40.0]);

    $action = app(GetStatsAction::class);

    $out = $action->execute();

    expect($out)->toHaveKeys(['top_movie_queries', 'top_person_queries'])
        ->and($out)->not->toHaveKeys(['average_request_time_ms', 'popular_hours']);
});

it('returns all sections when all cached', function () {
    Cache::flush();

    Cache::put(ComputeTopMovieQueriesStatsAction::CACHE_KEY, ['a new hope' => 60.0]);
    Cache::put(ComputeTopPersonQueriesStatsAction::CACHE_KEY, ['luke' => 40.0]);
    Cache::put(ComputeAverageRequestTimingStatsAction::CACHE_KEY, ['/api/people' => 120.123]);
    Cache::put(MostPopularHourOfDayStatsAction::CACHE_KEY, ['13' => 55.0]);

    $action = app(GetStatsAction::class);

    $out = $action->execute();

    expect($out)->toHaveKeys(['top_movie_queries', 'top_person_queries', 'average_request_time_ms', 'popular_hours']);
});
