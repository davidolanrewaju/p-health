<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisplayNotification
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $notifications = $user->notifications()->latest()->paginate(10);

        return view('pages.notification.index', compact('user', 'notifications'));
    }

    public function markAsRead($id) {
        $user = User::find(Auth::user()->id);
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    public function markAllAsRead() {
        $user = User::find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();

        return back();
    }

    public function deleteNotification($id) {
        $user = User::find(Auth::user()->id);
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();
    }
}
