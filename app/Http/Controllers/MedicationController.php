<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\User;
use App\Notifications\MedicationNotification;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class MedicationController
{
    private function determineStatus($startDate, $endDate)
    {
        $now = now()->startOfDay();
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        if ($now->gt($end)) {
            return 'completed';
        }
        if ($now->gte($start) && $now->lte($end)) {
            return 'active';
        }
        return 'inactive';
    }

    private function updateMedicationStatus()
    {
        $medications = Medication::all();

        foreach ($medications as $medication) {
            $newStatus = $this->determineStatus($medication->startDate, $medication->endDate);

            if ($medication->status !== $newStatus) {
                $medication->update(['status' => $newStatus]);
            }
        }
    }

    private function prepareGoogleEventData(Medication $medication, string $time)
    {
        $startDate = Carbon::parse($medication->startDate);
        $endDate = Carbon::parse($medication->endDate);
        $daysOfWeek = array_map(function ($day) {
            return strtoupper(substr($day, 0, 2));
        }, $medication->schedule['daysOfWeek']);

        $startDateTime = $startDate->copy()->setTimeFromTimeString($time);
        $endDateTime = $startDateTime->copy()->addMinutes(30); // Adjust duration as needed

        return [
            'summary' => "{$medication->name} - {$medication->dosage}",
            'description' => $medication->instructions,
            'start' => ['dateTime' => $startDateTime->toIso8601String(), 'timeZone' => config('app.timezone')],
            'end' => ['dateTime' => $endDateTime->toIso8601String(), 'timeZone' => config('app.timezone')],
            'recurrence' => ["RRULE:FREQ=WEEKLY;BYDAY=" . implode(',', $daysOfWeek) . ";UNTIL=" . $endDate->format('Ymd\THis\Z')],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $this->updateMedicationStatus();
        $medications = Medication::where('user_id', $user->id)->latest()->paginate(7);
        return view('pages.medication.index', compact('user', 'medications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $medication = $request->validate([
            'name' => 'required|string',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
            'medicationType' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'instructions' => 'required|string',
            'requiresFasting' => 'boolean',
        ]);

        $medication['user_id'] = Auth::id();
        $medication['schedule'] = [
            'times' => $request->input('schedule.times', []),
            'daysOfWeek' => $request->input('schedule.daysOfWeek', []),
        ];

        $medication['status'] = $this->determineStatus($medication['startDate'], $medication['endDate']);

        $newMedication = Medication::create($medication);

        if ($user->google_access_token) {
            $calendarService = new GoogleCalendarService($user);
            $eventIds = [];
            foreach ($newMedication->schedule['times'] as $time) {
                $eventData = $this->prepareGoogleEventData($newMedication, $time);
                $eventIds[] = $calendarService->createEvent($eventData);
            }
            $newMedication->update(['google_event_ids' => $eventIds]);
        }

        User::find(Auth::id())->notify(new MedicationNotification($newMedication, 'create'));

        return redirect()->route('medication')->with('success', 'Medication created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medication $medication)
    {
        $user = Auth::user();
        $medication->status = $this->determineStatus($medication->startDate, $medication->endDate);
        return view('pages.medication.show', compact('medication', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medication $medication)
    {
        try {
            $updatedMedication = $request->validate([
                'name' => 'string',
                'dosage' => 'string',
                'frequency' => 'string',
                'medicationType' => 'string',
                'startDate' => 'date',
                'endDate' => 'date',
                'instructions' => 'string',
                'requiresFasting' => 'boolean',
            ]);

            $updatedMedication['user_id'] = Auth::id();
            $updatedMedication['schedule'] = [
                'times' => $request->input('schedule.times', []),
                'daysOfWeek' => $request->input('schedule.daysOfWeek', []),
            ];

            $updatedMedication['status'] = $this->determineStatus($updatedMedication['startDate'], $updatedMedication['endDate']);

            $user = Auth::user();

            if ($user->google_access_token && $medication->google_event_ids) {
                $calendarService = new GoogleCalendarService($user);

                foreach ($medication->google_event_ids as $eventId) {
                    $calendarService->deleteEvent($eventId);
                }

                $eventIds = [];
                foreach ($updatedMedication['schedule']['times'] as $time) {
                    $eventData = $this->prepareGoogleEventData($medication, $time);
                    $eventIds[] = $calendarService->createEvent($eventData);
                }
                $updatedMedication['google_event_ids'] = $eventIds;
            }

            $medication->update($updatedMedication);

            User::find(Auth::id())->notify(new MedicationNotification($medication, 'update'));

            return redirect()->route('medication.show', $medication)
                ->with('success', 'Medication updated successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medication $medication)
    {
        $user = Auth::user();

        if ($user->google_access_token && $medication->google_event_ids) {
            $calendarService = new GoogleCalendarService($user);
            foreach ($medication->google_event_ids as $eventId) {
                $calendarService->deleteEvent($eventId);
            }
        }

        $medication->delete();

        User::find(Auth::id())->notify(new MedicationNotification($medication, 'delete'));

        return redirect()->route('medication')
            ->with('success', 'Medication deleted successfully!');
    }
}
