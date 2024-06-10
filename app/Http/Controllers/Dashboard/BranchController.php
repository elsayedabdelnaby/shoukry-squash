<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\WeekDay;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::all();
        return view('dashboard.branches.index', compact('branches'));
    }

    public function create(Request $request)
    {
        return view('dashboard.branches.edit')->with([
            'action' => route('dashboard.branches.store'),
            'method' => 'POST',
            'working_days' => WeekDay::cases()
        ]);
    }

    public function store(Request $request)
    {
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->location = $request->location;
        $branch->working_from = $request->working_from;
        $branch->working_to = $request->working_to;
        $branch->working_days = implode(',', $request->input('working_days'));
        $branch->save();
        return redirect('dashboard/branches')
            ->with(
                'success',
                __('dashboard.branch_created_successfully')
            );
    }

    public function edit(Request $request, Branch $branch)
    {
        return view('dashboard.branches.edit')->with([
            'branch' => $branch,
            'method' => 'PUT',
            'action' => route('dashboard.branches.update', ['branch' => $branch]),
            'working_days' => WeekDay::cases()
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->location = $request->location;
        $branch->working_from = $request->working_from;
        $branch->working_to = $request->working_to;
        $branch->working_days = implode(',', $request->input('working_days'));
        $branch->save();
        return redirect('dashboard/branches')
            ->with(
                'success',
                __('dashboard.branch_updated_successfully')
            );
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect('dashboard/branches')
            ->with(
                'success',
                __('dashboard.branch_deleted_successfully')
            );
    }
}
