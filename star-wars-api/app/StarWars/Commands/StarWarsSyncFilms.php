<?php

namespace App\StarWars\Commands;

use App\StarWars\Actions\SyncFilmsAction;
use App\Support\TimeTracker;
use Illuminate\Console\Command;

class StarWarsSyncFilms extends Command
{
    protected $signature = 'starwars:sync:films';

    protected $description = 'Synchronize Star Wars films from swapi.tech.';

    public function handle(SyncFilmsAction $action): int
    {
        $this->info('Syncing Star Wars films...');

        $timer = TimeTracker::start();

        $synced = $action->execute();

        $this->info('Synced '.$synced.' films in '.$timer->humanElapsed().'.');

        return self::SUCCESS;
    }
}
