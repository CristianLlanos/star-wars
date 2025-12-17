<?php

namespace App\Movies\Actions;

use App\Movies\Dto\GetMoviesOptions;
use App\Movies\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

class GetMoviesAction
{
    public function execute(GetMoviesOptions $options): LengthAwarePaginator
    {
        $query = Movie::query()
            ->select(['id', 'title', 'episode_id', 'uid'])
            ->orderBy('episode_id');

        if ($options->title !== null && $options->title !== '') {
            $query->where('title', 'like', '%'.$options->title.'%');
        }

        $paginator = $query->paginate($options->perPage, ['*'], 'page', $options->page);

        return $paginator;
    }
}
