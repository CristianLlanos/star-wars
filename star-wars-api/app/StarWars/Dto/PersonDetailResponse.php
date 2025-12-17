<?php

namespace App\StarWars\Dto;

/**
 * Person detail response.
 */
class PersonDetailResponse
{
    /**
     * @param  array{created?: string, edited?: string, name?: string, gender?: string, skin_color?: string, hair_color?: string, height?: string, eye_color?: string, mass?: string, birth_year?: string}  $properties
     */
    public function __construct(
        public string $uid,
        public ?string $url,
        public array $properties
    ) {}
}
