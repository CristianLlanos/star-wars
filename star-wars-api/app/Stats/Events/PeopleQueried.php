<?php

namespace App\Stats\Events;

class PeopleQueried extends BaseEvent
{
    public function __construct(string $title)
    {
        parent::__construct($title);
    }
}
