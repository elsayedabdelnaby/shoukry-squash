<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\WeekDay;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\FileService;
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
        $image = $this->uploadedFiles($request, Branch::$storagePath);
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->location = $request->location;
        $branch->working_from = $request->working_from;
        $branch->working_to = $request->working_to;
        $branch->working_days = implode(',', $request->input('working_days'));
        $branch->image = $image;
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
        $image = $this->uploadedFiles($request, Branch::$storagePath, $branch->id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->location = $request->location;
        $branch->working_from = $request->working_from;
        $branch->working_to = $request->working_to;
        $branch->image = $image;
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

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): array
    {
        $mainImage = '';
        $fileService = new FileService;

        if ($id) {
            $branch = Branch::find($id);
            $mainImage = $branch->image ? $branch->image : '';
            if ($request->hasFile('image')) {
                $mainImage = $fileService->verifyAndUploadFile($request->file('image'), $mainImage, 'public', $storagePath);
            }
        } else {
            if ($request->hasFile('image')) {
                $mainImage = $fileService->verifyAndUploadFile($request->file('image'), $mainImage, 'public', $storagePath);
            }
        }

        return $mainImage;
    }
}
