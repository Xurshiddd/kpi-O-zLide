<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return redirect()->route('profile.index');
    }
    public function markAsRead(Request $request)
    {
        Auth::user()->notifications()->update(['is_read' => true]);
        return back();
    }

}
