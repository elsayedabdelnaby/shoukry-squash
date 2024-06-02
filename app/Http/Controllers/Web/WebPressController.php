<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Press;

class WebPressController extends Controller
{

    public function index()
    {

        $press = Press::orderBy('id', 'asc')->paginate(10);
        return view('press')->with([
            'press' => $press
        ]);
    }

    public function show($slug)
    {
        $press = Press::where('slug', $slug)->first();
        return view('press_details')->with([
            'press' => $press
        ]);
    }
}
