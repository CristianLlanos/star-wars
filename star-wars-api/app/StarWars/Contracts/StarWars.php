<?php

namespace App\StarWars\Contracts;

use App\StarWars\Dto\FilmsListResponse;
use App\StarWars\Dto\PeoplePageRequest;
use App\StarWars\Dto\PeoplePageResponse;
use App\StarWars\Dto\PersonDetailResponse;

interface StarWars
{
    /**
     * Fetch a paginated people page.
     */
    public function getPeoplePage(PeoplePageRequest $request): PeoplePageResponse;

    /**
     * Fetch person details by URL.
     */
    public function getPersonDetailByUid(string $uid): PersonDetailResponse;

    /**
     * Fetch all films with their properties.
     */
    public function getFilms(): FilmsListResponse;
}
