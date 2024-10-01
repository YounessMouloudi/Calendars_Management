<?php

namespace App\Http\Controllers;

use App\Models\Calendrier;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('calendrier.events')->get();
        
        $currentYear = Carbon::now()->year;

        return view('dashboard', compact('users', 'currentYear'));

    }
}
