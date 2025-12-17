<?php

namespace App\StarWars\Adapters;

use App\StarWars\Contracts\StarWars;
use App\StarWars\Dto\FilmsListResponse;
use App\StarWars\Dto\PeoplePageRequest;
use App\StarWars\Dto\PeoplePageResponse;
use App\StarWars\Dto\PersonDetailResponse;
use App\Support\Http\Request as HttpRequest;

class SwapiTechAdapter implements StarWars
{
    public function __construct(
        public string $baseUrl = 'https://www.swapi.tech/api'
    ) {}

    public function getPeoplePage(PeoplePageRequest $request): PeoplePageResponse
    {
        $response = $this->client()
            ->get('/people')
            ->addQuery('page', $request->page)
            ->addQuery('limit', $request->limit)
            ->send();

        $payload = $response->json();

        $results = [];
        foreach ((array) data_get($payload, 'results', []) as $item) {
            $results[] = [
                'uid' => data_get($item, 'uid', ''),
                'name' => data_get($item, 'name', ''),
                'url' => data_get($item, 'url', ''),
            ];
        }

        return new PeoplePageResponse(
            nextUrl: data_get($payload, 'next'),
            results: $results,
        );
    }

    public function getPersonDetailByUid(string $uid): PersonDetailResponse
    {
        $response = $this->client()
            ->get('/people/'.$uid)
            ->send();

        $payload = $response->json();

        $uid = (string) data_get($payload, 'result.uid', '');
        $properties = (array) data_get($payload, 'result.properties', []);

        return new PersonDetailResponse(
            uid: $uid,
            url: (string) data_get($payload, 'result.url'),
            properties: $properties,
        );
    }

    public function getFilms(): FilmsListResponse
    {
        $response = $this->client()
            ->get('/films')
            ->send();

        $payload = $response->json();

        $films = [];
        foreach ((array) data_get($payload, 'result', []) as $item) {
            $films[] = [
                'uid' => (string) data_get($item, 'uid', ''),
                'url' => (string) data_get($item, 'url', ''),
                'properties' => (array) data_get($item, 'properties', []),
            ];
        }

        return new FilmsListResponse($films);
    }

    public function client(): HttpRequest
    {
        return HttpRequest::new($this->baseUrl);
    }
}
