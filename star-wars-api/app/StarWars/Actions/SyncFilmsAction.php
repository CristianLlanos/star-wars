<?php

namespace App\StarWars\Actions;

use App\Movies\Models\Movie;
use App\People\Models\Person;
use App\StarWars\Contracts\StarWars;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

final class SyncFilmsAction
{
    public function __construct(public StarWars $api) {}

    /**
     * Synchronize films from the StarWars API into the local database.
     *
     * @return int Number of films synced (created or updated)
     */
    public function execute(): int
    {
        $synced = 0;

        $films = $this->api->getFilms();

        foreach ($films->films as $item) {
            $synced += $this->syncFilm($item);
        }

        return $synced;
    }

    private function syncFilm(array $item): int
    {
        $uid = (string) data_get($item, 'uid', '');
        if ($uid === '') {
            return 0;
        }

        $properties = (array) data_get($item, 'properties', []);

        $movie = Movie::query()->updateOrCreate(
            ['uid' => $uid],
            $this->buildMovieAttributes($properties)
        );

        $characterUrls = (array) data_get($properties, 'characters', []);
        $uids = $this->extractCharacterUids($characterUrls);

        if (! empty($uids)) {
            $people = $this->fetchPeopleByUids($uids);
            $this->attachCharactersToMovie($movie, $people);
        }

        return 1;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return array<string, mixed>
     */
    private function buildMovieAttributes(array $properties): array
    {
        return [
            'created' => (string) data_get($properties, 'created', ''),
            'edited' => (string) data_get($properties, 'edited', ''),
            'producer' => (string) data_get($properties, 'producer', ''),
            'title' => (string) data_get($properties, 'title', ''),
            'episode_id' => (int) data_get($properties, 'episode_id', 0),
            'director' => (string) data_get($properties, 'director', ''),
            'release_date' => (string) data_get($properties, 'release_date', ''),
            'opening_crawl' => (string) data_get($properties, 'opening_crawl', ''),
        ];
    }

    /**
     * @param  array<int, string>  $urls
     * @return array<int, string>
     */
    private function extractCharacterUids(array $urls): array
    {
        if (empty($urls)) {
            return [];
        }

        $uids = [];

        foreach ($urls as $url) {
            $urlString = (string) $url;
            if ($urlString === '') {
                continue;
            }

            $path = (string) parse_url($urlString, PHP_URL_PATH);
            $path = trim($path, '/');
            if ($path === '') {
                continue;
            }

            $segments = explode('/', $path);
            $last = end($segments);
            if (is_string($last) && $last !== '') {
                $uids[] = $last;
            }
        }

        return $uids;
    }

    /**
     * @param  array<int, string>  $uids
     */
    private function fetchPeopleByUids(array $uids): EloquentCollection
    {
        if (empty($uids)) {
            return new EloquentCollection;
        }

        return Person::query()
            ->whereIn('uid', $uids)
            ->get(['id', 'uid']);
    }

    private function attachCharactersToMovie(Movie $movie, EloquentCollection $people): void
    {
        if ($people->isEmpty()) {
            return;
        }

        $movie->characters()->syncWithoutDetaching($people->pluck('id')->all());
    }
}
