<?php

namespace App\StarWars\Commands;

use App\StarWars\Actions\SyncPeopleAction;
use App\Support\TimeTracker;
use Illuminate\Console\Command;

class StarWarsSyncPeople extends Command
{
    private const PAGE_LIMIT = 10;

    protected $signature = 'starwars:sync:people';

    protected $description = 'Synchronize Star Wars people from swapi.tech.';

    public function handle(SyncPeopleAction $action): int
    {
        $this->info('Syncing Star Wars people...');

        $timer = TimeTracker::start();

        $synced = $action->execute();

        $this->info('Synced '.$synced.' people in '.$timer->humanElapsed().'.');

        return self::SUCCESS;
    }
}
