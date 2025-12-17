<?php

namespace App\Support;

class TimeTracker
{
    private ?float $startedAt = null;

    public function __construct()
    {
        $this->startedAt = microtime(true);
    }

    /**
     * Start tracking time.
     */
    public static function start(): static
    {
        return new static;
    }

    /**
     * Get the elapsed seconds since start.
     */
    public function elapsed(): float
    {
        if ($this->startedAt === null) {
            return 0.0;
        }

        return microtime(true) - $this->startedAt;
    }

    /**
     * Format elapsed time in a human friendly way.
     */
    public function humanElapsed(): string
    {
        return $this->formatElapsed($this->elapsed());
    }

    /**
     * Format the given seconds in a human friendly way.
     */
    private function formatElapsed(float $seconds): string
    {
        if ($seconds < 1) {
            return number_format($seconds * 1000, 0).'ms';
        }

        if ($seconds < 60) {
            return number_format($seconds, 2).'s';
        }

        $minutes = (int) floor($seconds / 60);
        $remaining = $seconds - ($minutes * 60);

        return $minutes.'m '.number_format($remaining, 2).'s';
    }
}
