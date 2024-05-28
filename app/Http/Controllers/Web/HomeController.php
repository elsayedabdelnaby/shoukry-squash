<?php

namespace App\Http\Controllers\Web;

use App\Models\Branch;
use App\Models\Mission;
use App\Models\Package;
use App\Models\Objective;
use App\Http\Controllers\Controller;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $missions = Mission::orderBy('id')->get();
        $objectives = Objective::orderBy('id')->get();
        $events = Event::where('show_in_home_page', true)->limit(10)->get();
        $upComingEvents = Event::where('date', '>=', date('Y-m-d'))
            ->orderBy('date', 'asc')
            ->get();
        return view('home')->with([
            'missions' => $missions,
            'objectives' => $objectives,
            'branches' => Branch::all(),
            'packages' => Package::all(),
            'events' => $events,
            'upComingEvents' => $upComingEvents
        ]);
    }
}
