<?php

namespace App\StarWars\Dto;

/**
 * @phpstan-type FilmItem array{
 *   uid: string,
 *   url: string,
 *   properties: array<string, mixed>
 * }
 */
class FilmsListResponse
{
    /**
     * @param  array<int, FilmItem>  $films
     */
    public function __construct(public array $films) {}
}
