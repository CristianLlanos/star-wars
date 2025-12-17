<?php

namespace App\Stats\Actions;

use App\Stats\LoggerAnalytics\Actions\ComputeAverageRequestTimingStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopMovieQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopPersonQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\MostPopularHourOfDayStatsAction;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

final readonly class GetStatsAction
{
    public function __construct(public CacheRepository $cache) {}

    /**
     * Return an aggregated structure with available stats from cache.
     *
     * @return array{
     *     top_movie_queries?: array<string, float>,
     *     top_person_queries?: array<string, float>,
     *     average_request_time_ms?: array<string, float>,
     *     popular_hours?: array<string, float>
     * }
     */
    public function execute(): array
    {
        $result = [];

        $movie = $this->cache->get(ComputeTopMovieQueriesStatsAction::CACHE_KEY);
        if (is_array($movie) && $movie !== []) {
            $result['top_movie_queries_percentage'] = $movie;
        }

        $person = $this->cache->get(ComputeTopPersonQueriesStatsAction::CACHE_KEY);
        if (is_array($person) && $person !== []) {
            $result['top_person_queries_percentage'] = $person;
        }

        $avg = $this->cache->get(ComputeAverageRequestTimingStatsAction::CACHE_KEY);
        if (is_array($avg) && $avg !== []) {
            $result['average_request_time_ms'] = $avg;
        }

        $hours = $this->cache->get(MostPopularHourOfDayStatsAction::CACHE_KEY);
        if (is_array($hours) && $hours !== []) {
            $result['popular_hours_percentage'] = $hours;
        }

        return $result;
    }
}
