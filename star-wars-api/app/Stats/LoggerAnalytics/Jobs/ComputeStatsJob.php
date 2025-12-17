<?php

namespace App\Stats\LoggerAnalytics\Jobs;

use App\Stats\LoggerAnalytics\Actions\ComputeAverageRequestTimingStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopMovieQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopPersonQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\MostPopularHourOfDayStatsAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ComputeStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public int $timeout = 60;

    public function __construct() {}

    public function handle(
        ComputeTopMovieQueriesStatsAction $movieAction,
        ComputeTopPersonQueriesStatsAction $personAction,
        ComputeAverageRequestTimingStatsAction $avgTimeAction,
        MostPopularHourOfDayStatsAction $popularHourAction,
    ): void {
        $movieAction->execute();
        $personAction->execute();
        $avgTimeAction->execute();
        $popularHourAction->execute();
    }
}
