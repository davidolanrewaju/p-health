<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\User;
use App\Notifications\MedicationNotification;
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $medications = Medication::where('user_id', $user->id)->latest()->paginate(7);
        foreach ($medications as $medication) {
            $medication->status = $this->determineStatus($medication->startDate, $medication->endDate);
        }
        return view('pages.medication.index', compact('user', 'medications'));
    }

    /**
     * Show the form for creating a new resource.
  public function create()
  {
    //
  }
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Medication $medication)
    // {
    //     //
    // }

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

            $medication->update($updatedMedication);

            // dd($medication);

            User::find(Auth::id())->notify(new MedicationNotification($medication, 'update'));

            return redirect()->route('medication.show', $medication)->with('success', 'Medication updated successfully!');;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medication $medication)
    {
        $medication->delete();

        User::find(Auth::id())->notify(new MedicationNotification($medication, 'delete'));

        return redirect()->route('medication')->with('success', 'Medication deleted successfully!');;
    }
}
