<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Court;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourtController extends Controller
{
    public function index(Request $request)
    {
        $courts = Court::all();
        return view('dashboard.courts.index', compact('courts'));
    }

    public function create(Request $request)
    {
        $branches = Branch::select('id', 'name')->get();
        return view('dashboard.courts.edit')->with([
            'action' => route('dashboard.courts.store'),
            'method' => 'POST',
            'branches' => $branches
        ]);
    }

    public function store(Request $request)
    {
        $court = new Court();
        $court->name = $request->name;
        $court->branch_id = $request->branch_id;
        $court->save();
        return redirect('dashboard/courts')
            ->with(
                'success',
                __('dashboard.court_created_successfully')
            );
    }

    public function edit(Request $request, Court $court)
    {
        $branches = Branch::select('id', 'name')->get();
        return view('dashboard.courts.edit')->with([
            'court' => $court,
            'method' => 'PUT',
            'action' => route('dashboard.courts.update', ['court' => $court]),
            'branches' => $branches
        ]);
    }

    public function update(Request $request, Court $court)
    {
        $court->name = $request->name;
        $court->branch_id = $request->branch_id;
        $court->save();
        return redirect('dashboard/courts')
            ->with(
                'success',
                __('dashboard.court_updated_successfully')
            );
    }

    public function destroy(Court $court)
    {
        $court->delete();
        return redirect('dashboard/courts')
            ->with(
                'success',
                __('dashboard.court_deleted_successfully')
            );
    }
}
