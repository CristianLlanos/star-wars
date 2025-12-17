<?php

namespace App\StarWars;

use App\StarWars\Adapters\SwapiTechAdapter;
use App\StarWars\Commands\StarWarsSync;
use App\StarWars\Commands\StarWarsSyncFilms;
use App\StarWars\Commands\StarWarsSyncPeople;
use App\StarWars\Contracts\StarWars;
use Illuminate\Support\ServiceProvider;

class StarWarsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->bind(StarWars::class, function (): SwapiTechAdapter {
            return new SwapiTechAdapter;
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StarWarsSync::class,
                StarWarsSyncFilms::class,
                StarWarsSyncPeople::class,
            ]);
        }
    }
}
