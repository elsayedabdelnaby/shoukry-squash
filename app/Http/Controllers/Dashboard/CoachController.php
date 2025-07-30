<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coach;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $coaches = Coach::all();
        return view('dashboard.coaches.index', compact('coaches'));
    }

    public function show(Coach $coach)
    {
        $coach->load('workingTimes');
        return view('dashboard.coaches.show', compact('coach'));
    }

    public function create(Request $request)
    {
        return view('dashboard.coaches.edit')->with([
            'action' => route('dashboard.coaches.store'),
            'method' => 'POST',
            'isMultiple' => false,
        ]);
    }

    public function store(Request $request)
    {
        $coach = new Coach();
        $coach->name = $request->name;
        $coach->title = $request->title;
        $coach->level = $request->level;
        $coach->cost_per_hour = $request->cost_per_hour;
        $coach->facebook_url = $request->facebook_url;
        $coach->instagram_url = $request->instagram_url;
        $coach->twitter_url = $request->twitter_url;
        $coach->brief = $request->brief;
        $coach->is_active = $request->is_active ? true : false;
        $coach->image = $this->uploadedFiles($request, Coach::$storagePath);
        $coach->save();
        return redirect('dashboard/coaches')
            ->with(
                'success',
                __('dashboard.coach_created_successfully')
            );
    }

    public function edit(Request $request, Coach $coach)
    {
        return view('dashboard.coaches.edit')->with([
            'coach' => $coach,
            'method' => 'PUT',
            'action' => route('dashboard.coaches.update', ['coach' => $coach]),
            'isMultiple' => false,
        ]);
    }

    public function update(Request $request, Coach $coach)
    {
        $coach->name = $request->name;
        $coach->title = $request->title;
        $coach->level = $request->level;
        $coach->cost_per_hour = $request->cost_per_hour;
        $coach->facebook_url = $request->facebook_url;
        $coach->instagram_url = $request->instagram_url;
        $coach->twitter_url = $request->twitter_url;
        $coach->brief = $request->brief;
        $coach->is_active = $request->is_active ? true : false;
        $coach->image = $this->uploadedFiles($request, Coach::$storagePath, $coach->id);
        $coach->save();
        return redirect('dashboard/coaches')
            ->with(
                'success',
                __('dashboard.coach_updated_successfully')
            );
    }

    public function destroy(Coach $coach)
    {
        $coach->delete();
        return redirect('dashboard/coaches')
            ->with(
                'success',
                __('dashboard.coach_deleted_successfully')
            );
    }

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): string
    {
        $image = '';
        if ($id) {
            $coach = Coach::find($id);
            $image = $coach->image ? $coach->image : '';
            if ($request->hasFile('image')) {
                $image = (new FileService)->verifyAndUploadFile($request->file('image'), $image, 'public', $storagePath);
            }
        } else {
            if ($request->hasFile('image')) {
                $image = (new FileService)->verifyAndUploadFile($request->file('image'), $image, 'public', $storagePath);
            }
        }
        return $image;
    }
}
