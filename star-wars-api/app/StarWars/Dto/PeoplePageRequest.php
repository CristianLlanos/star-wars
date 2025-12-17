<?php

namespace App\StarWars\Dto;

/**
 * @phpstan-type PeopleResult array{
 *   uid: string,
 *   name: string,
 *   url: string,
 * }
 */
class PeoplePageRequest
{
    public function __construct(
        public int $page,
        public int $limit
    ) {}
}
