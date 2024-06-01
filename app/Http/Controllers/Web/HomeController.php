<?php

namespace App\Http\Controllers\Web;

use App\Models\Branch;
use App\Models\Mission;
use App\Models\Package;
use App\Models\Objective;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Gallery;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $missions = Mission::orderBy('id')->get();
        $gallery = Gallery::orderBy('id')->get();
        $objectives = Objective::orderBy('id')->get();
        $events = Event::where('show_in_home_page', true)->limit(10)->get();
        $upComingEvents = Event::where('date', '>=', date('Y-m-d'))
            ->where('show_in_home_page', true)
            ->orderBy('date', 'asc')
            ->get();
        $coaches = Coach::all();
        return view('home')->with([
            'missions' => $missions,
            'objectives' => $objectives,
            'gallery' => $gallery,
            'branches' => Branch::all(),
            'packages' => Package::all(),
            'events' => $events,
            'upComingEvents' => $upComingEvents,
            'coaches' => $coaches
        ]);
    }


    public function contactus(Request $request)
    {
        $question = new Question();
        $question->name = $request->name;
        $question->phone_number = $request->phone_number;
        $question->subject = $request->subject;
        $question->message = $request->message;
        $question->save();
        session()->flash('success', __('web.question_created_successfully'));
        return redirect()->back();
    }
}
