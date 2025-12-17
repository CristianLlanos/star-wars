<?php

namespace App\People;

use App\Http\Controllers\Controller;
use App\People\Actions\GetPeopleAction;
use App\People\Actions\GetPersonAction;
use App\People\Dto\GetPeopleOptions;
use App\People\Requests\PeopleIndexRequest;
use App\People\Requests\ShowPersonRequest;
use Illuminate\Http\JsonResponse;

class PeopleController extends Controller
{
    public function index(PeopleIndexRequest $request, GetPeopleAction $action): JsonResponse
    {
        $validated = $request->validated();

        $options = new GetPeopleOptions(
            name: $validated['name'] ?? null,
            page: (int) $validated['page'],
            perPage: (int) $validated['per_page'],
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

    public function show(ShowPersonRequest $request, GetPersonAction $action): JsonResponse
    {
        $id = (int) $request->validated('id');

        $person = $action->execute($id);

        if ($person === null) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json([
            'data' => $person,
        ]);
    }
}
