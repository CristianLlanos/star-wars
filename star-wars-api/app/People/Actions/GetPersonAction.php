<?php

namespace App\People\Actions;

use App\People\Models\Person;

class GetPersonAction
{
    public function execute(int $id): ?Person
    {
        return Person::query()
            ->with('movies')
            ->find($id);
    }
}
