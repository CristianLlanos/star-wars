<?php

namespace App\Stats\Contracts;

interface AnalyticsEvent
{
    public function name(): string;

    public function member(): string;

    /**
     * @return array<string, mixed>
     */
    public function context(): array;
}
