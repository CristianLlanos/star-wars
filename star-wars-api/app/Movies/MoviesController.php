<?php

namespace App\Movies;

use App\Http\Controllers\Controller;
use App\Movies\Actions\GetMovieAction;
use App\Movies\Actions\GetMoviesAction;
use App\Movies\Dto\GetMoviesOptions;
use App\Movies\Requests\MoviesIndexRequest;
use App\Movies\Requests\ShowMovieRequest;
use Illuminate\Http\JsonResponse;

class MoviesController extends Controller
{
    public function index(MoviesIndexRequest $request, GetMoviesAction $action): JsonResponse
    {
        $validated = $request->validated();

        $options = new GetMoviesOptions(
            title: $validated['title'] ?? null,
            page: (int) ($validated['page'] ?? 1),
            perPage: (int) ($validated['per_page'] ?? 15),
        );

        $paginator = $action->execute($options);

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    public function show(ShowMovieRequest $request, GetMovieAction $action): JsonResponse
    {
        $id = (int) $request->validated('id');

        $film = $action->execute($id);

        if ($film === null) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json([
            'data' => $film,
        ]);
    }
}
