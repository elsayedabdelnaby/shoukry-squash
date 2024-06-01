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
        
        $gallery = Gallery::orderBy('id')->get();
        $events = Event::where('show_in_home_page', true)->orderBy('id', 'asc')->paginate(1);
        return view('events')->with([
            'gallery' => $gallery,
            'events' => $events
        ]);
    }

    public function show($event)
    {
        
        $gallery = Gallery::orderBy('id')->get();
        $event = Event::where('slug', $event)->first();
        return view('events_details')->with([
            'gallery' => $gallery,
            'event' => $event
        ]);
    }
}
