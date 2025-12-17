<?php

use App\Movies\MoviesController;
use App\People\PeopleController;
use App\Stats\Middleware\MoviesQueriedStatsMiddleware;
use App\Stats\Middleware\MovieViewedStatsMiddleware;
use App\Stats\Middleware\PeopleQueriedStatsMiddleware;
use App\Stats\Middleware\PersonViewedStatsMiddleware;
use App\Stats\StatsController;
use App\Support\RouteName;
use Illuminate\Support\Facades\Route;

Route::get('/people', [PeopleController::class, 'index'])->middleware(PeopleQueriedStatsMiddleware::class)->name(RouteName::PEOPLE_INDEX);
Route::get('/people/{id}', [PeopleController::class, 'show'])->middleware(PersonViewedStatsMiddleware::class)->whereNumber('id')->name(RouteName::PEOPLE_SHOW);

Route::get('/movies', [MoviesController::class, 'index'])->middleware(MoviesQueriedStatsMiddleware::class)->name(RouteName::MOVIES_INDEX);
Route::get('/movies/{id}', [MoviesController::class, 'show'])->middleware(MovieViewedStatsMiddleware::class)->whereNumber('id')->name(RouteName::MOVIES_SHOW);

Route::get('/stats', [StatsController::class, 'index'])->name(RouteName::STATS_INDEX);
