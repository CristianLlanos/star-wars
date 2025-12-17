<?php

namespace App\Stats\LoggerAnalytics\Actions;

use App\Stats\Events\RequestServed;
use App\Stats\LoggerAnalytics\LoggerAnalytics;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

final class ComputeAverageRequestTimingStatsAction
{
    public const string CACHE_KEY = RequestServed::class;

    private const int CACHE_TTL_MINUTES = 10;

    private const string EVENT_PATTERN = '/RequestServed\s+\{\"member\":\"([^\"]+)\",\"context\":\{\"request_time\":([0-9.]+)/';

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

        [$sums, $counts] = $this->aggregate($content);

        if ($counts === []) {
            return [];
        }

        return $this->computeAveragesMs($sums, $counts);
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
     * Aggregate raw seconds per member from the log content.
     *
     * @return array{0: array<string, float>, 1: array<string, int>}
     */
    protected function aggregate(string $content): array
    {
        $sums = [];
        $counts = [];

        foreach (preg_split('/\r?\n/', $content) as $line) {
            if ($line === '') {
                continue;
            }

            if (preg_match(self::EVENT_PATTERN, $line, $matches) === 1) {
                $member = $matches[1];
                $seconds = (float) $matches[2];

                if ($member === '') {
                    continue;
                }

                $sums[$member] = ($sums[$member] ?? 0.0) + $seconds;
                $counts[$member] = ($counts[$member] ?? 0) + 1;
            }
        }

        return [$sums, $counts];
    }

    /**
     * @param  array<string, float>  $sumsSeconds
     * @param  array<string, int>  $counts
     * @return array<string, float>
     */
    private function computeAveragesMs(array $sumsSeconds, array $counts): array
    {
        $averages = [];

        foreach ($sumsSeconds as $member => $sumSeconds) {
            $count = $counts[$member] ?? 0;
            if ($count <= 0) {
                continue;
            }

            // Convert to milliseconds as a friendlier unit.
            $averages[$member] = round(($sumSeconds / $count) * 1000, 3);
        }

        // Sort by slowest first.
        arsort($averages);

        return $averages;
    }
}
