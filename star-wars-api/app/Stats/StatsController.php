<?php

namespace App\Stats;

use App\Http\Controllers\Controller;
use App\Stats\Actions\GetStatsAction;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    public function index(GetStatsAction $stats): JsonResponse
    {
        return response()->json($stats->execute());
    }
}
