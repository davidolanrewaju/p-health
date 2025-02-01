<?php

namespace App\Interfaces;

interface GoogleCalendarInterface
{
    public function createEvent($eventData);
    public function updateEvent($eventId, $eventData);
    public function deleteEvent($eventId);
}
