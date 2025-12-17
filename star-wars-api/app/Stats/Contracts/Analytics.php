<?php

namespace App\Stats\Contracts;

interface Analytics
{
    public function track(AnalyticsEvent $event): void;
}
