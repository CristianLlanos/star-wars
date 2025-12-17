<?php

namespace App\Stats\LoggerAnalytics\Actions;

use App\Stats\Events\RequestServed;
use App\Stats\LoggerAnalytics\LoggerAnalytics;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

final class MostPopularHourOfDayStatsAction
{
    public const string CACHE_KEY = RequestServed::class.':PopularHours';

    private const int TOP_LIMIT = 5;

    private const int CACHE_TTL_MINUTES = 10;

    /**
     * Match a Laravel log line beginning with a timestamp and containing the RequestServed event name.
     * Captures the hour component (00-23) as group 1.
     */
    private const string EVENT_PATTERN = '/^\[\d{4}-\d{2}-\d{2}\s+(\d{2}):\d{2}:\d{2}].*RequestServed\s+\{/';

    public function __construct(public readonly Filesystem $files, public readonly CacheRepository $cache) {}

    /**
     * @return array<string, float>
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
     * Aggregate raw counts per hour (00-23) from the log content for RequestServed events.
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
                $hour = $matches[1] ?? null;

                if ($hour === null || $hour === '') {
                    continue;
                }

                $counts[$hour] = ($counts[$hour] ?? 0) + 1;
            }
        }

        return $counts;
    }

    /**
     * @param  array<string, int>  $counts
     * @return array<string, float>
     */
    private function computeTopPercentageStats(array $counts): array
    {
        if ($counts === []) {
            return [];
        }

        arsort($counts);

        $total = array_sum($counts);

        if ($total <= 0) {
            return [];
        }

        $top = array_slice($counts, 0, self::TOP_LIMIT, true);

        $stats = [];

        foreach ($top as $hour => $count) {
            $stats[$hour] = round(($count / $total) * 100, 2);
        }

        return $stats;
    }
}
