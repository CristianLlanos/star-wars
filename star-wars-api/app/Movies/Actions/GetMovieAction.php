<?php

namespace App\Movies\Actions;

use App\Movies\Models\Movie;

class GetMovieAction
{
    public function execute(int $id): ?Movie
    {
        return Movie::query()
            ->with('characters')
            ->find($id);
    }
}
