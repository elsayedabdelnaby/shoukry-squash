<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Gallery;

class EventsController extends Controller
{

    public function index()
    {

        $events = Event::orderBy('id', 'asc')->paginate(10);
        return view('events')->with([
            'events' => $events
        ]);
    }

    public function show($event)
    {
        $event = Event::where('slug', $event)->first();
        return view('events_details')->with([
            'event' => $event
        ]);
    }
}
