<?php

namespace App\Stats\Events;

class MovieViewed extends BaseEvent
{
    public function __construct(string $movieId)
    {
        parent::__construct($movieId);
    }
}
