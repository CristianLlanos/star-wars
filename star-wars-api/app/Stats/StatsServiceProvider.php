<?php

namespace App\Stats;

use App\Stats\Commands\ComputeStatsCommand;
use App\Stats\Contracts\Analytics;
use App\Stats\LoggerAnalytics\LoggerAnalytics;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class StatsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->bind(Analytics::class, function (Container $container): Analytics {
            return new LoggerAnalytics(
                $container->make(LoggerInterface::class)
            );
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ComputeStatsCommand::class,
            ]);
        }
    }
}
