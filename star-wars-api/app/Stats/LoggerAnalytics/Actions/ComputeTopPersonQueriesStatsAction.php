<?php

namespace App\Stats\LoggerAnalytics\Actions;

use App\Stats\Events\PeopleQueried;
use App\Stats\LoggerAnalytics\LoggerAnalytics;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

final class ComputeTopPersonQueriesStatsAction
{
    public const string CACHE_KEY = PeopleQueried::class;

    private const int TOP_LIMIT = 5;

    private const int CACHE_TTL_MINUTES = 10;

    private const string EVENT_PATTERN = '/PeopleQueried\s+\{\"member\":\"([^\"]+)\"/';

    public function __construct(public readonly Filesystem $files, public readonly CacheRepository $cache) {}

    /**
     * Compute top people query stats as percentages and cache the result.
     *
     * @return array<{member: string, percentage: float}>
     */
    public function execute(): array
    {
        $results = $this->computeStats();

        $this->store($results);

        return $results;
    }

    public function computeStats(): array
    {
        $content = $this->readFile();

        $counts = $this->aggregate($content);

        if ($counts === []) {
            return [];
        }

        return $this->computeTopPercentageStats($counts);
    }

    private function readFile(): string
    {
        $path = storage_path(LoggerAnalytics::EVENTS_LOG_PATH);

        if (! $this->files->exists($path)) {
            return '';
        }

        try {
            return $this->files->get($path);
        } catch (FileNotFoundException $exception) {
            return '';
        }
    }

    /**
     * @param  array<string, float>  $result
     */
    private function store(array $result): void
    {
        $this->cache->put(self::CACHE_KEY, $result, now()->addMinutes(self::CACHE_TTL_MINUTES));
    }

    /**
     * Aggregate raw counts per member from the log content.
     *
     * @return array<string, int>
     */
    protected function aggregate(string $content): array
    {
        $counts = [];

        foreach (preg_split('/\r?\n/', $content) as $line) {
            if ($line === '') {
                continue;
            }

            if (preg_match(self::EVENT_PATTERN, $line, $matches) === 1) {
                $member = $matches[1];

                if ($member === '') {
                    continue;
                }

                $counts[$member] = ($counts[$member] ?? 0) + 1;
            }
        }

        return $counts;
    }

    /**
     * @param  array<string, int>  $totalCounts
     * @return array<string, float>
     */
    private function computeTopPercentageStats(array $totalCounts): array
    {
        if ($totalCounts === []) {
            return [];
        }

        arsort($totalCounts);

        $totalQueries = array_sum($totalCounts);

        if ($totalQueries <= 0) {
            return [];
        }

        $topQueries = array_slice($totalCounts, 0, self::TOP_LIMIT, true);

        $stats = [];

        foreach ($topQueries as $member => $count) {
            $stats[$member] = round(($count / $totalQueries) * 100, 2);
        }

        return $stats;
    }
}
