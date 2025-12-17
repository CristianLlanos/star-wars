<?php

namespace App\Stats\Commands;

use App\Stats\LoggerAnalytics\Actions\ComputeAverageRequestTimingStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopMovieQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\ComputeTopPersonQueriesStatsAction;
use App\Stats\LoggerAnalytics\Actions\MostPopularHourOfDayStatsAction;
use Illuminate\Console\Command;

final class ComputeStatsCommand extends Command
{
    protected $signature = 'stats:compute';

    protected $description = 'Compute MoviesQueried stats from events log and print results.';

    private const array TOP_MOVIE_QUERIES_TABLE_HEADERS = ['Query', 'Percentage'];

    private const array TOP_PERSON_QUERIES_TABLE_HEADERS = ['Query', 'Percentage'];

    private const array AVERAGE_REQUEST_TIME_TABLE_HEADERS = ['Request', 'Average Time (ms)'];

    private const array MOST_POPULAR_HOUR_TABLE_HEADERS = ['Hour', 'Percentage'];

    public function __construct(
        public readonly ComputeTopMovieQueriesStatsAction $movieAction,
        public readonly ComputeTopPersonQueriesStatsAction $personAction,
        public readonly ComputeAverageRequestTimingStatsAction $avgTimeAction,
        public readonly MostPopularHourOfDayStatsAction $popularHourAction,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $movieRows = $this->getTopMovieQueriesStats();

        if (count($movieRows) > 0) {
            $this->table(self::TOP_MOVIE_QUERIES_TABLE_HEADERS, $movieRows);
        }

        $personRows = $this->getTopPersonQueriesStats();

        if (count($personRows) > 0) {
            $this->table(self::TOP_PERSON_QUERIES_TABLE_HEADERS, $personRows);
        }

        $avgRows = $this->getAverageRequestTimingStats();

        if (count($avgRows) > 0) {
            $this->table(self::AVERAGE_REQUEST_TIME_TABLE_HEADERS, $avgRows);
        }

        $popularHourRows = $this->getMostPopularHoursOfDayStats();

        if (count($popularHourRows) > 0) {
            $this->table(self::MOST_POPULAR_HOUR_TABLE_HEADERS, $popularHourRows);
        }

        $this->info('Done.');

        return self::SUCCESS;
    }

    public function getTopMovieQueriesStats(): array
    {
        $this->info('Computing Top Movie Queries stats...');

        $stats = $this->movieAction->execute();

        if ($stats === []) {
            $this->warn('No Movie Queries found.');

            return [];
        }

        return $this->formatPercentageStats($stats);
    }

    public function getTopPersonQueriesStats(): array
    {
        $this->info('Computing Top Person Queries stats...');

        $stats = $this->personAction->execute();

        if ($stats === []) {
            $this->warn('No Person Queries found.');

            return [];
        }

        return $this->formatPercentageStats($stats);
    }

    public function getAverageRequestTimingStats(): array
    {
        $this->info('Computing Average Request Timings...');

        $averages = $this->avgTimeAction->execute();

        if ($averages === []) {
            $this->warn('No Requests found.');

            return [];
        }

        return $this->formatAveragesMs($averages);
    }

    public function getMostPopularHoursOfDayStats(): array
    {
        $this->info('Computing Most Popular Hours of Day UTC...');

        $stats = $this->popularHourAction->execute();

        if ($stats === []) {
            $this->warn('No Requests found.');

            return [];
        }

        return $this->formatPercentageStats($stats);
    }

    /**
     * @return array<string, string>
     */
    public function formatPercentageStats(array $stats): array
    {
        $rows = [];

        foreach ($stats as $member => $stat) {
            $rows[] = [$member, ((string) $stat).'%'];
        }

        return $rows;
    }

    /**
     * @param  array<string, float>  $averages
     * @return array<string, string>
     */
    public function formatAveragesMs(array $averages): array
    {
        $rows = [];

        foreach ($averages as $member => $avgMs) {
            $rows[] = [$member, (string) $avgMs];
        }

        return $rows;
    }
}
