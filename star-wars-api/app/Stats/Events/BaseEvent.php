<?php

namespace App\Stats\Events;

use App\Stats\Contracts\AnalyticsEvent;

abstract class BaseEvent implements AnalyticsEvent
{
    public function __construct(
        protected string $member,
        protected array $context = []
    ) {}

    public function name(): string
    {
        return class_basename(static::class);
    }

    public function member(): string
    {
        return $this->member;
    }

    public function context(): array
    {
        return $this->context;
    }
}
