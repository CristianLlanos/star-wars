<?php

use App\People\Models\Person;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\artisan;

it('syncs people from swapi', function () {
    Http::fake([
        'swapi.tech/api/people?page=1*' => Http::response([
            'next' => 'https://www.swapi.tech/api/people?page=2',
            'results' => [
                ['name' => 'Luke', 'url' => 'https://www.swapi.tech/api/people/1', 'uid' => '1'],
            ],
        ]),
        'swapi.tech/api/people?page=2*' => Http::response([
            'next' => null,
            'results' => [
                ['name' => 'Leia', 'url' => 'https://www.swapi.tech/api/people/5', 'uid' => '5'],
            ],
        ]),
        'swapi.tech/api/people/1' => Http::response([
            'result' => [
                'uid' => '1',
                'properties' => [
                    'name' => 'Luke Skywalker',
                    'birth_year' => '19BBY',
                    'created' => '2025-01-01T00:00:00.000000Z',
                    'edited' => '2025-01-02T00:00:00.000000Z',
                    'gender' => 'male',
                    'skin_color' => 'fair',
                    'hair_color' => 'blonde',
                    'height' => '172',
                    'eye_color' => 'blue',
                    'mass' => '77',
                    'homeworld' => 'https://www.swapi.tech/api/planets/1',
                    'url' => 'https://www.swapi.tech/api/people/1',
                ],
            ],
        ]),
        'swapi.tech/api/people/5' => Http::response([
            'result' => [
                'uid' => '5',
                'properties' => [
                    'name' => 'Leia Organa',
                    'birth_year' => '19BBY',
                    'created' => '2025-01-01T00:00:00.000000Z',
                    'edited' => '2025-01-03T00:00:00.000000Z',
                    'gender' => 'female',
                    'skin_color' => 'light',
                    'hair_color' => 'brown',
                    'height' => '150',
                    'eye_color' => 'brown',
                    'mass' => '49',
                    'homeworld' => 'https://www.swapi.tech/api/planets/2',
                    'url' => 'https://www.swapi.tech/api/people/5',
                ],
            ],
        ]),
    ]);

    artisan('starwars:sync:people')->assertSuccessful();

    expect(Person::query()->count())->toBe(2);
    expect(Person::query()->where('uid', '1')->first())
        ->name->toBe('Luke Skywalker')
        ->homeworld->toBe('https://www.swapi.tech/api/planets/1');
    expect(Person::query()->where('uid', '5')->first())
        ->edited->toBe('2025-01-03T00:00:00.000000Z');
});
