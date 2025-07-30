<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coach;
use App\Models\CoachWorkingTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoachWorkingTimeController extends Controller
{
    public function index(Request $request)
    {
        $coachWorkingTimes = CoachWorkingTime::with('coach')->paginate(10);
        return view('dashboard.coach-working-times.index', compact('coachWorkingTimes'));
    }

    public function create(Request $request)
    {
        $coaches = Coach::with('workingTimes')->get();
        $branches = \App\Models\Branch::orderBy('name')->get();
        $weekDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $selectedCoachId = $request->get('coach_id');
        
        // Prepare working times data for JavaScript
        $coachesWorkingTimes = $coaches->map(function($coach) {
            $workingTimesByDay = [];
            foreach ($coach->workingTimes->groupBy('week_day') as $day => $times) {
                $workingTimesByDay[$day] = $times->map(function($time) {
                    return [
                        'start_time' => $time->start_time,
                        'end_time' => $time->end_time,
                        'branch_id' => $time->branch_id
                    ];
                })->toArray();
            }
            return [
                'id' => $coach->id,
                'name' => $coach->name,
                'working_times' => $workingTimesByDay
            ];
        });
        
        return view('dashboard.coach-working-times.edit')->with([
            'action' => route('dashboard.coach-working-times.store'),
            'method' => 'POST',
            'coaches' => $coaches,
            'branches' => $branches,
            'coachesWorkingTimes' => $coachesWorkingTimes,
            'weekDays' => $weekDays,
            'selectedCoachId' => $selectedCoachId,
            'isMultiple' => false,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'coach_id' => 'required|exists:coaches,id',
            'branch_id' => 'nullable|exists:branches,id',
            'week_day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for time conflicts (same coach, same day, ANY branch)
        $conflicts = CoachWorkingTime::where('coach_id', $request->coach_id)
            ->where('week_day', $request->week_day)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    // Check if new time overlaps with existing times
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                });
            })
            ->get();

        if ($conflicts->count() > 0) {
            $conflictTimes = $conflicts->map(function($conflict) {
                $branchName = $conflict->branch ? $conflict->branch->name : 'No Branch';
                return $conflict->start_time . ' - ' . $conflict->end_time . ' (' . $branchName . ')';
            })->implode(', ');
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['time_conflict' => __('dashboard.time_conflict_message', ['times' => $conflictTimes])]);
        }

        $coachWorkingTime = new CoachWorkingTime();
        $coachWorkingTime->coach_id = $request->coach_id;
        $coachWorkingTime->branch_id = $request->branch_id;
        $coachWorkingTime->week_day = $request->week_day;
        $coachWorkingTime->start_time = $request->start_time;
        $coachWorkingTime->end_time = $request->end_time;
        $coachWorkingTime->save();

        return redirect()->route('dashboard.coaches.show', ['coach' => $request->coach_id])
            ->with('success', __('dashboard.coach_working_time_created_successfully'));
    }

    public function show(CoachWorkingTime $coachWorkingTime)
    {
        $coachWorkingTime->load('coach');
        return view('dashboard.coach-working-times.show', compact('coachWorkingTime'));
    }

    public function edit(CoachWorkingTime $coachWorkingTime)
    {
        $coaches = Coach::with('workingTimes')->get();
        $branches = \App\Models\Branch::orderBy('name')->get();
        $weekDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        // Prepare working times data for JavaScript
        $coachesWorkingTimes = $coaches->map(function($coach) {
            $workingTimesByDay = [];
            foreach ($coach->workingTimes->groupBy('week_day') as $day => $times) {
                $workingTimesByDay[$day] = $times->map(function($time) {
                    return [
                        'start_time' => $time->start_time,
                        'end_time' => $time->end_time,
                        'branch_id' => $time->branch_id
                    ];
                })->toArray();
            }
            return [
                'id' => $coach->id,
                'name' => $coach->name,
                'working_times' => $workingTimesByDay
            ];
        });
        
        return view('dashboard.coach-working-times.edit')->with([
            'coachWorkingTime' => $coachWorkingTime,
            'method' => 'PUT',
            'action' => route('dashboard.coach-working-times.update', ['coachWorkingTime' => $coachWorkingTime]),
            'coaches' => $coaches,
            'branches' => $branches,
            'coachesWorkingTimes' => $coachesWorkingTimes,
            'weekDays' => $weekDays,
            'isMultiple' => false,
        ]);
    }

    public function update(Request $request, CoachWorkingTime $coachWorkingTime)
    {
        $request->validate([
            'coach_id' => 'required|exists:coaches,id',
            'branch_id' => 'nullable|exists:branches,id',
            'week_day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for time conflicts (same coach, same day, ANY branch, excluding current record)
        $conflicts = CoachWorkingTime::where('coach_id', $request->coach_id)
            ->where('week_day', $request->week_day)
            ->where('id', '!=', $coachWorkingTime->id)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    // Check if new time overlaps with existing times
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                });
            })
            ->get();

        if ($conflicts->count() > 0) {
            $conflictTimes = $conflicts->map(function($conflict) {
                $branchName = $conflict->branch ? $conflict->branch->name : 'No Branch';
                return $conflict->start_time . ' - ' . $conflict->end_time . ' (' . $branchName . ')';
            })->implode(', ');
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['time_conflict' => __('dashboard.time_conflict_message', ['times' => $conflictTimes])]);
        }

        $coachWorkingTime->coach_id = $request->coach_id;
        $coachWorkingTime->branch_id = $request->branch_id;
        $coachWorkingTime->week_day = $request->week_day;
        $coachWorkingTime->start_time = $request->start_time;
        $coachWorkingTime->end_time = $request->end_time;
        $coachWorkingTime->save();

        return redirect()->route('dashboard.coaches.show', ['coach' => $request->coach_id])
            ->with('success', __('dashboard.coach_working_time_updated_successfully'));
    }

    public function destroy(CoachWorkingTime $coachWorkingTime)
    {
        $coachId = $coachWorkingTime->coach_id;
        $coachWorkingTime->delete();
        return redirect()->route('dashboard.coaches.show', ['coach' => $coachId])
            ->with('success', __('dashboard.coach_working_time_deleted_successfully'));
    }
}
