<?php

namespace App\People\Dto;

readonly class GetPeopleOptions
{
    public function __construct(
        public ?string $name,
        public int $page,
        public int $perPage,
    ) {}
}
