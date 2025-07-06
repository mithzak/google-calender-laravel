<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function today()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(env('GOOGLE_PUBLIC_API_KEY'));
        $service = new Google_Service_Calendar($client);

        $calendarId = env('CALENDAR_ID');
        $today = Carbon::today('UTC');
        $start = $today->copy()->startOfDay()->toRfc3339String();
        $end = $today->copy()->endOfDay()->toRfc3339String();

        $optParams = [
            'timeMin' => $start,
            'timeMax' => $end,
            'maxResults' => 10,
            'singleEvents' => true,
            'orderBy' => 'startTime',
        ];

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        $meetings = [];
        foreach ($events as $event) {
            $start = $event->start->dateTime ?? $event->start->date;
            $meetings[] = $event->getSummary() . ' at ' . $start;
        }

        return view('calendar', ['meetings' => $meetings]);
    }
} 