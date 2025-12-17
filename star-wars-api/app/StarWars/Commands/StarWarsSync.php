<?php

namespace App\StarWars\Commands;

use App\Support\TimeTracker;
use Illuminate\Console\Command;

class StarWarsSync extends Command
{
    protected $signature = 'starwars:sync';

    protected $description = 'Run full Star Wars synchronization: people first, then films.';

    public function handle(): int
    {
        $this->info('Starting full Star Wars sync...');

        $timer = TimeTracker::start();

        $this->call('starwars:sync:people');

        $this->call('starwars:sync:films');

        $this->info('Star Wars sync complete in '.$timer->humanElapsed().'.');

        return self::SUCCESS;
    }
}
