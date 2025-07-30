<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Player;
use App\Models\Coach;
use App\Models\Court;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\CoachWorkingTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['player', 'coach', 'court', 'branch', 'package'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('dashboard.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $players = Player::orderBy('name')->get();
        $coaches = Coach::orderBy('name')->get();
        $courts = Court::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        $packages = Package::orderBy('name')->get();

        // Check if we have pre-selected player and package (from subscription)
        $selectedPlayerId = $request->get('player_id');
        $selectedPackageId = $request->get('package_id');
        
        // Check if we have pre-selected values from timetable
        $selectedBranchId = $request->get('branch_id');
        $selectedCourtId = $request->get('court_id');
        $selectedDate = $request->get('date');
        $selectedStartTime = $request->get('start_time');
        $selectedEndTime = $request->get('end_time');
        
        $isFromSubscription = false;
        $selectedPlayer = null;
        $selectedPackage = null;
        $activeSubscription = null;

        if ($selectedPlayerId && $selectedPackageId) {
            $isFromSubscription = true;
            $selectedPlayer = Player::find($selectedPlayerId);
            $selectedPackage = Package::find($selectedPackageId);
            
            if ($selectedPlayer && $selectedPackage) {
                // Check for active subscription
                $activeSubscription = Subscription::where('player_id', $selectedPlayerId)
                    ->where('package_id', $selectedPackageId)
                    ->where('status', 'active')
                    ->first();
            }
        }

        // Prepare data for dynamic filtering
        $branchesData = $branches->map(function($branch) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'courts' => $branch->courts->map(function($court) {
                    return [
                        'id' => $court->id,
                        'name' => $court->name
                    ];
                })
            ];
        });

        $coachesData = $coaches->map(function($coach) {
            return [
                'id' => $coach->id,
                'name' => $coach->name,
                'working_times' => $coach->workingTimes->map(function($workingTime) {
                    return [
                        'week_day' => $workingTime->week_day,
                        'start_time' => $workingTime->start_time,
                        'end_time' => $workingTime->end_time,
                        'branch_id' => $workingTime->branch_id
                    ];
                })
            ];
        });

        return view('dashboard.reservations.create', compact(
            'players', 
            'coaches', 
            'courts', 
            'branches', 
            'packages',
            'isFromSubscription',
            'selectedPlayer',
            'selectedPackage',
            'activeSubscription',
            'branchesData',
            'coachesData',
            'selectedBranchId',
            'selectedCourtId',
            'selectedDate',
            'selectedStartTime',
            'selectedEndTime'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Determine if this is a subscription-based reservation
        $isFromSubscription = $request->has('is_from_subscription') && $request->is_from_subscription;
        
        $validationRules = [
            'player_id' => 'required|exists:players,id',
            'coach_id' => 'nullable|exists:coaches,id',
            'court_id' => 'nullable|exists:courts,id',
            'branch_id' => 'nullable|exists:branches,id',
            'package_id' => 'nullable|exists:packages,id',
            'type' => 'required|in:private_session,team_training,match_play,court_rent,package_session',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration_minutes' => 'required|integer|min:45|max:45', // Fixed to 45 minutes
        ];

        if (!$isFromSubscription) {
            $validationRules['price'] = 'required|numeric|min:0';
            $validationRules['payment_method'] = 'required|in:visa,fawry,cash,transfer';
            $validationRules['payment_document'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $request->validate($validationRules);

        // Validate coach availability if coach is selected
        if ($request->coach_id && $request->branch_id && $request->date && $request->start_time && $request->end_time) {
            $coach = Coach::find($request->coach_id);
            $branch = Branch::find($request->branch_id);
            $selectedDate = \Carbon\Carbon::parse($request->date);
            $dayName = $selectedDate->format('l'); // Gets day name (Monday, Tuesday, etc.)
            
            // Check if coach works at this branch on this day
            $workingTime = CoachWorkingTime::where('coach_id', $request->coach_id)
                ->where('branch_id', $request->branch_id)
                ->where('week_day', $dayName)
                ->first();
            
            if (!$workingTime) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['coach_id' => "Coach {$coach->name} does not work at {$branch->name} on {$dayName}"]);
            }
            
            // Check if the requested time falls within coach's working hours
            $requestStartTime = \Carbon\Carbon::parse($request->start_time);
            $requestEndTime = \Carbon\Carbon::parse($request->end_time);
            $workingStartTime = \Carbon\Carbon::parse($workingTime->start_time);
            $workingEndTime = \Carbon\Carbon::parse($workingTime->end_time);
            
            if ($requestStartTime < $workingStartTime || $requestEndTime > $workingEndTime) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['start_time' => "Coach {$coach->name} works at {$branch->name} on {$dayName} from {$workingTime->start_time} to {$workingTime->end_time}"]);
            }
        }

        // Check for availability conflicts
        $availabilityCheck = $this->checkAvailability($request);
        if (!$availabilityCheck['available']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['availability' => $availabilityCheck['message']]);
        }

        // Validate subscription and session limits for subscription-based reservations
        if ($isFromSubscription) {
            $player = Player::find($request->player_id);
            $package = Package::find($request->package_id);
            
            // Check if player has active subscription
            $activeSubscription = Subscription::where('player_id', $request->player_id)
                ->where('package_id', $request->package_id)
                ->where('status', 'active')
                ->first();
            
            if (!$activeSubscription) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['subscription' => 'Player does not have an active subscription for this package']);
            }
            
            // Check weekly session limit
            $weekStart = \Carbon\Carbon::parse($request->date)->startOfWeek();
            $weekEnd = \Carbon\Carbon::parse($request->date)->endOfWeek();
            
            $weeklyReservations = Reservation::where('player_id', $request->player_id)
                ->where('package_id', $request->package_id)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->count();
            
            if ($weeklyReservations >= $package->sessions_per_week) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['session_limit' => "Player has already booked {$weeklyReservations} sessions this week. Maximum allowed: {$package->sessions_per_week}"]);
            }
        }

        $data = $request->all();
        
        if ($isFromSubscription) {
            $data['price'] = 0;
            $data['payment_method'] = null;
            $data['payment_document'] = null;
        } else {
            // Handle payment document upload for non-subscription reservations
            if ($request->hasFile('payment_document')) {
                $file = $request->file('payment_document');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/payment_documents', $fileName);
                $data['payment_document'] = $fileName;
            }
        }

        Reservation::create($data);

        return redirect()->route('dashboard.reservations.index')
            ->with('success', 'Reservation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::with(['player', 'coach', 'court', 'branch', 'package'])->findOrFail($id);
        return view('dashboard.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $players = Player::orderBy('name')->get();
        $coaches = Coach::orderBy('name')->get();
        $courts = Court::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        $packages = Package::orderBy('name')->get();

        return view('dashboard.reservations.edit', compact('reservation', 'players', 'coaches', 'courts', 'branches', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'player_id' => 'required|exists:players,id',
            'coach_id' => 'nullable|exists:coaches,id',
            'court_id' => 'nullable|exists:courts,id',
            'branch_id' => 'nullable|exists:branches,id',
            'package_id' => 'nullable|exists:packages,id',
            'type' => 'required|in:private_session,team_training,match_play,court_rent,package_session',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration_minutes' => 'required|integer|min:45|max:45', // Fixed to 45 minutes
            'price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:visa,fawry,cash,transfer',
            'payment_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Check availability (excluding current reservation)
        $availabilityCheck = $this->checkAvailability($request, $id);
        if (!$availabilityCheck['available']) {
            return back()->withErrors(['availability' => $availabilityCheck['message']])->withInput();
        }

        // Check if player has active subscription for package-based reservations
        if ($request->package_id) {
            $activeSubscription = Subscription::where('player_id', $request->player_id)
                ->where('package_id', $request->package_id)
                ->where('status', 'active')
                ->where('start_date', '<=', $request->date)
                ->where('end_date', '>=', $request->date)
                ->first();

            if (!$activeSubscription) {
                return back()->withErrors(['subscription' => 'Player does not have an active subscription for this package.'])->withInput();
            }

            // Check weekly session limit (excluding current reservation)
            $weekStart = Carbon::parse($request->date)->startOfWeek();
            $weekEnd = Carbon::parse($request->date)->endOfWeek();
            
            $weeklyReservations = Reservation::where('player_id', $request->player_id)
                ->where('package_id', $request->package_id)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->where('id', '!=', $id) // Exclude current reservation
                ->count();

            $package = Package::find($request->package_id);
            $maxSessionsPerWeek = $package->sessions_per_week;

            if ($weeklyReservations >= $maxSessionsPerWeek) {
                return back()->withErrors(['session_limit' => "Player has already booked {$weeklyReservations} sessions this week. Maximum allowed: {$maxSessionsPerWeek} sessions per week."])->withInput();
            }
        }

        $data = $request->all();

        // Handle payment document upload
        if ($request->hasFile('payment_document')) {
            // Delete old file if exists
            if ($reservation->payment_document) {
                Storage::disk('public')->delete($reservation->payment_document);
            }

            $file = $request->file('payment_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('payment_documents', $fileName, 'public');
            $data['payment_document'] = $filePath;
        }

        $reservation->update($data);

        return redirect()->route('dashboard.reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        // Delete payment document if exists
        if ($reservation->payment_document) {
            Storage::disk('public')->delete($reservation->payment_document);
        }

        $reservation->delete();

        return redirect()->route('dashboard.reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }

    /**
     * Calculate coach cost for a specific month
     */
    public function coachCostCalculation(Request $request)
    {
        $request->validate([
            'coach_id' => 'required|exists:coaches,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $coach = Coach::findOrFail($request->coach_id);
        $month = Carbon::parse($request->month . '-01');
        
        // Get all reservations for the coach in the specified month
        $reservations = Reservation::where('coach_id', $coach->id)
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->get();

        // Calculate total hours (45 minutes = 0.75 hours)
        $totalSessions = $reservations->count();
        $totalHours = $totalSessions * 0.75; // 45 minutes = 0.75 hours

        // Get coach's cost per hour from working times
        $coachWorkingTime = CoachWorkingTime::where('coach_id', $coach->id)->first();
        $costPerHour = $coachWorkingTime ? $coachWorkingTime->cost_per_hour : 0;
        
        $totalCost = $totalHours * $costPerHour;

        return response()->json([
            'coach_name' => $coach->name,
            'month' => $month->format('F Y'),
            'total_sessions' => $totalSessions,
            'total_hours' => $totalHours,
            'cost_per_hour' => $costPerHour,
            'total_cost' => $totalCost,
            'reservations' => $reservations->map(function($reservation) {
                return [
                    'id' => $reservation->id,
                    'date' => $reservation->date,
                    'start_time' => $reservation->start_time,
                    'end_time' => $reservation->end_time,
                    'player_name' => $reservation->player->name,
                    'type' => $reservation->type,
                ];
            })
        ]);
    }

    /**
     * Show coach cost calculation form
     */
    public function coachCostForm()
    {
        $coaches = Coach::orderBy('name')->get();
        return view('dashboard.reservations.coach-cost', compact('coaches'));
    }

    /**
     * Check availability for the requested time slot
     */
    private function checkAvailability(Request $request, $excludeReservationId = null)
    {
        $date = $request->date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $playerId = $request->player_id;
        $coachId = $request->coach_id;
        $courtId = $request->court_id;

        // Base query for time overlap
        $timeOverlapQuery = function ($query) use ($startTime, $endTime) {
            $query->where(function ($subQ) use ($startTime, $endTime) {
                $subQ->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });
        };

        // Check player availability
        $playerConflict = Reservation::where('date', $date)
            ->where('player_id', $playerId)
            ->where($timeOverlapQuery);
        
        if ($excludeReservationId) {
            $playerConflict->where('id', '!=', $excludeReservationId);
        }
        
        if ($playerConflict->exists()) {
            return ['available' => false, 'message' => 'Player is not available at this time.'];
        }

        // Check coach availability
        if ($coachId) {
            $coachConflict = Reservation::where('date', $date)
                ->where('coach_id', $coachId)
                ->where($timeOverlapQuery);
            
            if ($excludeReservationId) {
                $coachConflict->where('id', '!=', $excludeReservationId);
            }
            
            if ($coachConflict->exists()) {
                return ['available' => false, 'message' => 'Coach is not available at this time.'];
            }
        }

        // Check court availability
        if ($courtId) {
            $courtConflict = Reservation::where('date', $date)
                ->where('court_id', $courtId)
                ->where($timeOverlapQuery);
            
            if ($excludeReservationId) {
                $courtConflict->where('id', '!=', $excludeReservationId);
            }
            
            if ($courtConflict->exists()) {
                return ['available' => false, 'message' => 'Court is not available at this time.'];
            }
        }

        return ['available' => true, 'message' => 'Time slot is available.'];
    }

    /**
     * Check session limit for a player and package
     */
    public function checkSessionLimit(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'package_id' => 'required|exists:packages,id',
            'date' => 'required|date',
        ]);

        $player = Player::find($request->player_id);
        $package = Package::find($request->package_id);
        
        // Check if player has active subscription
        $activeSubscription = Subscription::where('player_id', $request->player_id)
            ->where('package_id', $request->package_id)
            ->where('status', 'active')
            ->where('start_date', '<=', $request->date)
            ->where('end_date', '>=', $request->date)
            ->first();

        if (!$activeSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found for this package and date.'
            ]);
        }

        // Get weekly session count
        $weekStart = Carbon::parse($request->date)->startOfWeek();
        $weekEnd = Carbon::parse($request->date)->endOfWeek();
        
        $bookedSessions = Reservation::where('player_id', $request->player_id)
            ->where('package_id', $request->package_id)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->count();

        $maxSessions = $package->sessions_per_week;
        $remainingSessions = $maxSessions - $bookedSessions;
        $canBook = $remainingSessions > 0;

        return response()->json([
            'success' => true,
            'package_name' => $package->name,
            'max_sessions' => $maxSessions,
            'booked_sessions' => $bookedSessions,
            'remaining_sessions' => $remainingSessions,
            'can_book' => $canBook,
            'week_start' => $weekStart->format('d/m/Y'),
            'week_end' => $weekEnd->format('d/m/Y'),
        ]);
    }
}
