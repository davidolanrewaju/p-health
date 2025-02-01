<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\GoogleCalendarInterface;
use App\Services\GoogleCalendarService;

class CalendarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GoogleCalendarInterface::class, GoogleCalendarService::class);
    }
}
