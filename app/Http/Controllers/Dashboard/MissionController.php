<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Mission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MissionController extends Controller
{
    public function index(Request $request)
    {
        $missions = Mission::all();
        return view('dashboard.missions.index', compact('missions'));
    }

    public function create(Request $request)
    {
        return view('dashboard.missions.edit')->with([
            'action' => route('dashboard.missions.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $mission = new Mission();
        $mission->mission = $request->mission;
        $mission->save();
        return redirect('dashboard/missions')
            ->with(
                'success',
                __('dashboard.mission_created_successfully')
            );
    }

    public function edit(Request $request, Mission $mission)
    {
        return view('dashboard.missions.edit')->with([
            'mission' => $mission,
            'method' => 'PUT',
            'action' => route('dashboard.missions.update', ['mission' => $mission]),
        ]);
    }

    public function update(Request $request, Mission $mission)
    {
        $mission->mission = $request->mission;
        $mission->save();
        return redirect('dashboard/missions')
            ->with(
                'success',
                __('dashboard.mission_updated_successfully')
            );
    }

    public function destroy(Mission $mission)
    {
        $mission->delete();
        return redirect('dashboard/missions')
            ->with(
                'success',
                __('dashboard.mission_deleted_successfully')
            );
    }
}
