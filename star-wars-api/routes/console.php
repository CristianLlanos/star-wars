<?php

use App\Stats\LoggerAnalytics\Jobs\ComputeStatsJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new ComputeStatsJob)->everyFiveMinutes()->withoutOverlapping();
