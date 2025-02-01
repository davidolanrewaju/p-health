<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    //
    public function index() {
        $user = Auth::user();
        $medications = Medication::where('user_id', $user->id)->get();

        return view('dashboard', compact('user', 'medications'));
    }
}
