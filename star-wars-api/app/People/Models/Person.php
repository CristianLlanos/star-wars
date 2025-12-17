<?php

namespace App\People\Models;

use App\Movies\Models\Movie;
use App\Movies\Models\MovieCharacter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string|null $created
 * @property string|null $edited
 * @property string $name
 * @property string|null $gender
 * @property string|null $skin_color
 * @property string|null $hair_color
 * @property string|null $height
 * @property string|null $eye_color
 * @property string|null $mass
 * @property string|null $birth_year
 * @property string $uid
 * @property-read \Illuminate\Support\Collection<int, \App\Movies\Models\Movie> $movies
 */
class Person extends Model
{
    /** @use HasFactory<\Database\Factories\PersonFactory> */
    use HasFactory;

    protected $fillable = [
        'created',
        'edited',
        'name',
        'gender',
        'skin_color',
        'hair_color',
        'height',
        'eye_color',
        'mass',
        'birth_year',
        'uid',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_person')
            ->using(MovieCharacter::class);
    }
}
