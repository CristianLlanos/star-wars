<?php

namespace App\Movies\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieCharacter extends Pivot
{
    protected $table = 'movie_person';

    protected $guarded = [];
}
