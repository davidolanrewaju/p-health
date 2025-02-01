<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController
{
    //
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $currentDate = Carbon::createFromFormat('Y-m', $month);
        $date = $currentDate->copy()->startOfMonth();
        $user = Auth::user();

        $medications = Medication::where('user_id', $user->id)
            ->where(function ($query) use ($date) {
                $query->whereDate('startDate', '<=', $date->endOfMonth())
                    ->whereDate('endDate', '>=', $date->startOfMonth());
            })
            ->get();

        foreach ($medications as $medication) {
            $medication->status = $this->determineStatus($medication->startDate, $medication->endDate);
        }

        return view('pages.schedule', [
            'medications' => $medications,
            'user' => $user,
            'currentDate' => $currentDate
        ]);
    }

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
}
