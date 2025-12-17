<?php

namespace App\Stats\LoggerAnalytics;

use App\Stats\Contracts\Analytics;
use App\Stats\Contracts\AnalyticsEvent;
use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;

class LoggerAnalytics implements Analytics
{
    public const string EVENTS_LOG_PATH = 'logs/events.log';

    const string CHANNEL = 'event';

    private LoggerInterface $logger;

    public function __construct(LogManager $logManager)
    {
        $this->logger = $logManager->channel(static::CHANNEL);
    }

    public function track(AnalyticsEvent $event): void
    {
        $context = [
            'member' => $event->member(),
        ];

        if (! empty($event->context())) {
            $context['context'] = $event->context();
        }

        $this->logger->info($event->name(), $context);
    }
}
