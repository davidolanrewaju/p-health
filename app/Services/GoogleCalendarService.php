<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use App\Interfaces\GoogleCalendarInterface;
use App\Models\User;
use Carbon\Carbon;

class GoogleCalendarService implements GoogleCalendarInterface
{
    protected $client;
    protected $calendarId;

    public function __construct(User $user)
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setAccessToken($user->google_access_token);
        $this->client->refreshToken($user->google_refresh_token);
        $this->calendarId = $user->google_calendar_id ?? 'primary';

        if ($this->client->isAccessTokenExpired()) {
            $this->refreshToken($user);
        }
    }

    private function refreshToken(User $user)
    {
        $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
        $newToken = $this->client->getAccessToken();
        $user->update([
            'google_access_token' => $newToken['access_token'],
            'google_refresh_token' => $newToken['refresh_token'] ?? $user->google_refresh_token,
        ]);
    }

    public function createEvent($eventData)
    {
        $service = new Calendar($this->client);
        $event = new Event();

        $event->setSummary($eventData['summary']);
        $event->setDescription($eventData['description']);

        $start = new EventDateTime();
        $start->setDateTime($eventData['start']);
        $event->setStart($start);

        $end = new EventDateTime();
        $end->setDateTime($eventData['end']);
        $event->setEnd($end);

        if (isset($eventData['recurrence'])) {
            $event->setRecurrence($eventData['recurrence']);
        }

        $createdEvent = $service->events->insert($this->calendarId, $event);
        return $createdEvent->getId();
    }

    public function updateEvent($eventId, $eventData)
    {
        $service = new Calendar($this->client);
        $event = $service->events->get($this->calendarId, $eventId);

        $event->setSummary($eventData['summary']);
        $event->setDescription($eventData['description']);

        $start = new EventDateTime();
        $start->setDateTime($eventData['start']);
        $event->setStart($start);

        $end = new EventDateTime();
        $end->setDateTime($eventData['end']);
        $event->setEnd($end);

        if (isset($eventData['recurrence'])) {
            $event->setRecurrence($eventData['recurrence']);
        }

        return $service->events->update($this->calendarId, $eventId, $event);
    }

    public function deleteEvent($eventId)
    {
        $service = new Calendar($this->client);
        return $service->events->delete($this->calendarId, $eventId);
    }
}
