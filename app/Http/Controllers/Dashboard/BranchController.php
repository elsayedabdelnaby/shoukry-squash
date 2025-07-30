<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\WeekDay;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Coach;
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
            'working_days' => WeekDay::cases(),
            'isMultiple' => false,
        ]);
    }

    public function store(Request $request)
    {
        $image = $this->uploadedFiles($request, Branch::$storagePath);
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->location = $request->location;
        $branch->starting_at = $request->starting_at;
        $branch->ending_at = $request->ending_at;
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
            'working_days' => WeekDay::cases(),
            'isMultiple' => false,
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $image = $this->uploadedFiles($request, Branch::$storagePath, $branch->id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->location = $request->location;
        $branch->starting_at = $request->starting_at;
        $branch->ending_at = $request->ending_at;
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

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): string
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::with(['courts', 'coaches'])->findOrFail($id);
        return view('dashboard.branches.show', compact('branch'));
    }

    /**
     * Show the branch timetable with courts, coaches, and reservations
     */
    public function timetable(string $id)
    {
        $branch = Branch::with(['courts', 'coaches'])->findOrFail($id);
        
        // Get the requested week (default to current week)
        $weekStart = request('week', now()->startOfWeek()->format('Y-m-d'));
        $selectedWeek = \Carbon\Carbon::parse($weekStart);
        
        // Generate the week dates (Monday to Sunday)
        $weekDates = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDates[] = $selectedWeek->copy()->addDays($i)->format('Y-m-d');
        }
        
        // Get all courts for this branch
        $courts = $branch->courts;
        
        // Get all coaches who work at this branch
        $coaches = Coach::whereHas('workingTimes', function($query) use ($branch) {
            $query->where('branch_id', $branch->id);
        })->with(['workingTimes' => function($query) use ($branch) {
            $query->where('branch_id', $branch->id);
        }])->get();
        
        // Get all reservations for this branch for the entire week
        $reservations = \App\Models\Reservation::where('branch_id', $branch->id)
            ->whereIn('date', $weekDates)
            ->with(['player', 'coach', 'court', 'package'])
            ->get();
        
        // Generate time slots (from 6 AM to 11 PM, 45-minute intervals)
        $timeSlots = [];
        $startTime = \Carbon\Carbon::parse('06:00');
        $endTime = \Carbon\Carbon::parse('23:00');
        
        while ($startTime <= $endTime) {
            $timeSlots[] = $startTime->format('H:i');
            $startTime->addMinutes(45);
        }
        
        // Get previous and next weeks for navigation
        $previousWeek = $selectedWeek->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $selectedWeek->copy()->addWeek()->format('Y-m-d');
        
        // Calculate weekly statistics
        $totalReservations = $reservations->count();
        $totalSlots = count($timeSlots) * $courts->count() * 7; // 7 days
        $availableSlots = $totalSlots - $totalReservations;
        
        return view('dashboard.branches.timetable', compact(
            'branch', 
            'courts', 
            'coaches', 
            'reservations', 
            'timeSlots', 
            'weekDates',
            'selectedWeek',
            'previousWeek',
            'nextWeek',
            'totalReservations',
            'availableSlots',
            'totalSlots'
        ));
    }
}
