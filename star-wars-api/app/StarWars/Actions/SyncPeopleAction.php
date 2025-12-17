<?php

namespace App\StarWars\Actions;

use App\People\Models\Person;
use App\StarWars\Contracts\StarWars;
use App\StarWars\Dto\PeoplePageRequest;

final class SyncPeopleAction
{
    private const PAGE_LIMIT = 10;

    public function __construct(public StarWars $api) {}

    /**
     * Synchronize all people from the StarWars API into the local database.
     *
     * @return int Number of people synced (created or updated)
     */
    public function execute(): int
    {
        $page = 1;
        $synced = 0;
        $nextUrl = null;

        do {
            $synced += $this->syncPage($page);

            $nextUrl = $this->api->getPeoplePage(new PeoplePageRequest(page: $page, limit: self::PAGE_LIMIT))->nextUrl;
            $page++;
        } while ($nextUrl !== null);

        return $synced;
    }

    private function syncPage(int $page): int
    {
        $response = $this->api->getPeoplePage(new PeoplePageRequest(page: $page, limit: self::PAGE_LIMIT));

        $count = 0;

        foreach ($response->results as $result) {
            $uid = (string) ($result['uid'] ?? '');
            if ($uid === '') {
                continue;
            }

            $count += $this->syncPersonByUid($uid);
        }

        return $count;
    }

    private function syncPersonByUid(string $personUid): int
    {
        $detail = $this->api->getPersonDetailByUid($personUid);

        $uid = $detail->uid !== '' ? $detail->uid : $personUid;

        if ($uid === '') {
            return 0;
        }

        $properties = $detail->properties;

        Person::query()->updateOrCreate(
            ['uid' => $uid],
            $this->buildPersonAttributes($properties)
        );

        return 1;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return array<string, mixed>
     */
    private function buildPersonAttributes(array $properties): array
    {
        return [
            'created' => (string) ($properties['created'] ?? ''),
            'edited' => (string) ($properties['edited'] ?? ''),
            'name' => (string) ($properties['name'] ?? ''),
            'gender' => (string) ($properties['gender'] ?? ''),
            'skin_color' => (string) ($properties['skin_color'] ?? ''),
            'hair_color' => (string) ($properties['hair_color'] ?? ''),
            'height' => (string) ($properties['height'] ?? ''),
            'eye_color' => (string) ($properties['eye_color'] ?? ''),
            'mass' => (string) ($properties['mass'] ?? ''),
            'birth_year' => (string) ($properties['birth_year'] ?? ''),
        ];
    }
}
