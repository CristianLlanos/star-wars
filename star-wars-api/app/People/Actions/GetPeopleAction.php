<?php

namespace App\People\Actions;

use App\People\Dto\GetPeopleOptions;
use App\People\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPeopleAction
{
    public function execute(GetPeopleOptions $options): LengthAwarePaginator
    {
        $query = Person::query()
            ->orderBy('name');

        if ($options->name !== null && $options->name !== '') {
            $query->where('name', 'like', '%'.$options->name.'%');
        }

        $paginator = $query->paginate($options->perPage, ['*'], 'page', $options->page);

        return $paginator;
    }
}
