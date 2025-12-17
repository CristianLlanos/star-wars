<?php

namespace App\Movies\Models;

use App\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string|null $created
 * @property string|null $edited
 * @property string|null $producer
 * @property string $title
 * @property int $episode_id
 * @property string|null $director
 * @property string|null $release_date
 * @property string|null $opening_crawl
 * @property string $uid
 * @property-read \Illuminate\Support\Collection<int, \App\People\Models\Person> $characters
 */
class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory;

    protected $fillable = [
        'created',
        'edited',
        'producer',
        'title',
        'episode_id',
        'director',
        'release_date',
        'opening_crawl',
        'uid',
    ];

    protected function casts(): array
    {
        return [
            'episode_id' => 'integer',
        ];
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'movie_person')
            ->using(MovieCharacter::class);
    }
}
