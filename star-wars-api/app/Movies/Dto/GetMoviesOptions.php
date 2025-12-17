<?php

namespace App\Movies\Dto;

readonly class GetMoviesOptions
{
    public function __construct(
        public ?string $title,
        public int $page,
        public int $perPage,
    ) {}
}
