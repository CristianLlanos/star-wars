<?php

namespace App\Stats\Events;

class PersonViewed extends BaseEvent
{
    public function __construct(string $personId)
    {
        parent::__construct($personId);
    }
}
