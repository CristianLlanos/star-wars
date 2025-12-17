<?php

namespace App\StarWars\Dto;

/**
 * Paginated people response.
 */
class PeoplePageResponse
{
    /**
     * @param  array<int, array{uid: string, name: string, url: string}>  $results
     */
    public function __construct(
        public ?string $nextUrl,
        public array $results
    ) {}
}
