<?php

namespace App\Stats\Events;

class MoviesQueried extends BaseEvent
{
    public function __construct(string $title)
    {
        parent::__construct($title);
    }
}
