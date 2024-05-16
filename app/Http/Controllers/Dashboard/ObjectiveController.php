<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Objective;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObjectiveController extends Controller
{
    public function index(Request $request)
    {
        $objectives = Objective::all();
        return view('dashboard.objectives.index', compact('objectives'));
    }

    public function create(Request $request)
    {
        return view('dashboard.objectives.edit')->with([
            'action' => route('dashboard.objectives.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $objective = new Objective();
        $objective->objective = $request->objective;
        $objective->save();
        return redirect('dashboard/objectives')
            ->with(
                'success',
                __('dashboard.objective_created_successfully')
            );
    }

    public function edit(Request $request, Objective $objective)
    {
        return view('dashboard.objectives.edit')->with([
            'objective' => $objective,
            'method' => 'PUT',
            'action' => route('dashboard.objectives.update', ['objective' => $objective]),
        ]);
    }

    public function update(Request $request, Objective $objective)
    {
        $objective->objective = $request->objective;
        $objective->save();
        return redirect('dashboard/objectives')
            ->with(
                'success',
                __('dashboard.objective_updated_successfully')
            );
    }

    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect('dashboard/objectives')
            ->with(
                'success',
                __('dashboard.objective_deleted_successfully')
            );
    }
}
