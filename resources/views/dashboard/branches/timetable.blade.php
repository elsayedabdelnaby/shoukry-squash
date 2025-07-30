@extends('dashboard.layouts.app')

@section('title', __('dashboard.branch_timetable') . ' - ' . $branch->name)

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.branch_timetable'),
        'short_description' => __('dashboard.view_branch_timetable_with_courts_coaches_and_reservations'),
        'breadcrumbs' => [
            ['name' => __('dashboard.branches'), 'url' => route('dashboard.branches.index')],
            ['name' => $branch->name, 'url' => route('dashboard.branches.show', $branch)],
            ['name' => __('dashboard.timetable'), 'url' => '#'],
        ],
    ]);
@endsection

@section('content')
    <!-- Branch Information Header -->
    <div class="card card-custom mb-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-calendar"></i> {{ __('dashboard.branch_timetable') }} - {{ $branch->name }}
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.reservations.create') }}" 
                   class="btn btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>
                    {{ __('dashboard.new_reservation') }}
                </a>
                <a href="{{ route('dashboard.branches.show', $branch) }}" 
                   class="btn btn-secondary font-weight-bolder ml-2">
                    <i class="la la-arrow-left"></i>
                    {{ __('dashboard.back_to_branch') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('dashboard.branch') }}:</label>
                        <span class="form-control-plaintext">{{ $branch->name }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('dashboard.address') }}:</label>
                        <span class="form-control-plaintext">{{ $branch->address }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('dashboard.operating_hours') }}:</label>
                        <span class="form-control-plaintext">{{ $branch->starting_at }} - {{ $branch->ending_at }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('dashboard.courts') }}:</label>
                        <span class="form-control-plaintext">{{ $courts->count() }} {{ __('dashboard.courts') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Week Navigation -->
    <div class="card card-custom mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="{{ route('dashboard.branches.timetable', ['branch' => $branch, 'week' => $previousWeek]) }}" 
                       class="btn btn-outline-primary">
                        <i class="la la-chevron-left"></i> {{ __('dashboard.previous_week') }}
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <h4 class="mb-0">
                        <span class="badge badge-primary">
                            {{ $selectedWeek->format('d/m/Y') }} - {{ $selectedWeek->copy()->addDays(6)->format('d/m/Y') }}
                        </span>
                    </h4>
                    <small class="text-muted">{{ __('dashboard.week') }} {{ $selectedWeek->format('W') }} {{ __('dashboard.of') }} {{ $selectedWeek->format('Y') }}</small>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('dashboard.branches.timetable', ['branch' => $branch, 'week' => $nextWeek]) }}" 
                       class="btn btn-outline-primary">
                        {{ __('dashboard.next_week') }} <i class="la la-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-custom card-stretch">
                <div class="card-body text-center">
                    <div class="font-size-h1 font-weight-bold text-primary">
                        {{ $courts->count() }}
                    </div>
                    <div class="font-size-h6 text-muted">{{ __('dashboard.available_courts') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom card-stretch">
                <div class="card-body text-center">
                    <div class="font-size-h1 font-weight-bold text-success">
                        {{ $coaches->count() }}
                    </div>
                    <div class="font-size-h6 text-muted">{{ __('dashboard.working_coaches') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom card-stretch">
                <div class="card-body text-center">
                    <div class="font-size-h1 font-weight-bold text-info">
                        {{ $totalReservations }}
                    </div>
                    <div class="font-size-h6 text-muted">{{ __('dashboard.total_reservations') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom card-stretch">
                <div class="card-body text-center">
                    <div class="font-size-h1 font-weight-bold text-warning">
                        {{ $availableSlots }}
                    </div>
                    <div class="font-size-h6 text-muted">{{ __('dashboard.available_slots') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Timetable with Individual Courts and Coaches -->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-clock"></i> {{ __('dashboard.weekly_timetable') }}
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="btn-group" role="group">
                    {{-- <button type="button" class="btn btn-sm btn-outline-success" id="filter-all">
                        {{ __('dashboard.all') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="filter-available">
                        {{ __('dashboard.available') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning" id="filter-reserved">
                        {{ __('dashboard.reserved') }}
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover timetable-table">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 100px;">{{ __('dashboard.time') }}</th>
                            @foreach($weekDates as $date)
                                @php
                                    $dayDate = \Carbon\Carbon::parse($date);
                                    $isToday = $date == now()->format('Y-m-d');
                                @endphp
                                @foreach($courts as $court)
                                    <th class="text-center {{ $isToday ? 'table-warning' : '' }}" style="min-width: 120px;">
                                        <div class="font-weight-bold">{{ $dayDate->format('D') }}</div>
                                        <div class="text-muted">{{ $dayDate->format('d/m') }}</div>
                                        <div class="badge badge-info badge-sm">{{ $court->name }}</div>
                                        @if($isToday)
                                            <small class="badge badge-warning">{{ __('dashboard.today') }}</small>
                                        @endif
                                    </th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $timeSlot)
                            @php
                                $endTime = \Carbon\Carbon::parse($timeSlot)->addMinutes(45)->format('H:i');
                                $isCurrentTime = now()->format('Y-m-d') == now()->format('Y-m-d') && 
                                               $timeSlot <= now()->format('H:i') && 
                                               $endTime > now()->format('H:i');
                            @endphp
                            <tr class="{{ $isCurrentTime ? 'table-warning' : '' }}">
                                <td class="text-center font-weight-bold {{ $isCurrentTime ? 'bg-warning' : '' }}">
                                    <div>{{ $timeSlot }}</div>
                                    <small class="text-muted">{{ $endTime }}</small>
                                </td>
                                @foreach($weekDates as $date)
                                    @php
                                        $dayDate = \Carbon\Carbon::parse($date);
                                        $isToday = $date == now()->format('Y-m-d');
                                        $dayName = $dayDate->format('l'); // Monday, Tuesday, etc.
                                        
                                        // Get coaches working on this day at this time
                                        $workingCoaches = $coaches->filter(function($coach) use ($timeSlot, $endTime, $branch, $dayName) {
                                            return $coach->workingTimes->some(function($wt) use ($timeSlot, $endTime, $branch, $dayName) {
                                                if ($wt->branch_id != $branch->id || $wt->week_day != $dayName) {
                                                    return false;
                                                }
                                                $wtStart = \Carbon\Carbon::parse($wt->start_time);
                                                $wtEnd = \Carbon\Carbon::parse($wt->end_time);
                                                $slotStart = \Carbon\Carbon::parse($timeSlot);
                                                $slotEnd = \Carbon\Carbon::parse($endTime);
                                                
                                                return $slotStart >= $wtStart && $slotEnd <= $wtEnd;
                                            });
                                        });
                                        
                                        $hasWorkingCoach = $workingCoaches->count() > 0;
                                    @endphp
                                    @foreach($courts as $court)
                                        @php
                                            // Get reservation for this specific court, date and time
                                            $courtReservation = $reservations->where('court_id', $court->id)
                                                ->where('date', $date)
                                                ->where('start_time', $timeSlot)
                                                ->first();
                                            
                                            $hasReservation = $courtReservation !== null;
                                            $isAvailable = $hasWorkingCoach && !$hasReservation;
                                        @endphp
                                        <td class="text-center {{ $isToday && $isCurrentTime ? 'bg-warning' : '' }}" 
                                            data-type="{{ $hasWorkingCoach ? ($hasReservation ? 'reserved' : 'available') : 'closed' }}">
                                            @if($hasWorkingCoach)
                                                @if($hasReservation)
                                                    <div class="reservation-info">
                                                        <div class="badge badge-danger mb-1">{{ __('dashboard.reserved') }}</div>
                                                        @if($courtReservation->player)
                                                            <div class="font-weight-bold small">{{ $courtReservation->player->name }}</div>
                                                        @endif
                                                        @if($courtReservation->coach)
                                                            <div class="text-muted small">{{ $courtReservation->coach->name }}</div>
                                                        @endif
                                                        @if($courtReservation->package)
                                                            <div class="badge badge-{{ $courtReservation->package->type == 'Team' ? 'primary' : ($courtReservation->package->type == 'Academy' ? 'success' : 'warning') }} badge-sm">
                                                                {{ $courtReservation->package->name }}
                                                            </div>
                                                        @endif
                                                        <div class="mt-1">
                                                            <a href="{{ route('dashboard.reservations.show', $courtReservation) }}" 
                                                               class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.view') }}">
                                                                <i class="la la-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="available-info">
                                                        <div class="badge badge-success mb-1">{{ __('dashboard.available') }}</div>
                                                        
                                                        <!-- Show working coaches -->
                                                        <div class="working-coaches mb-2">
                                                            <small class="text-muted">{{ __('dashboard.working_coaches') }}:</small>
                                                            @foreach($workingCoaches->take(2) as $coach)
                                                                <div class="badge badge-primary badge-sm">{{ $coach->name }}</div>
                                                            @endforeach
                                                            @if($workingCoaches->count() > 2)
                                                                <div class="badge badge-secondary badge-sm">+{{ $workingCoaches->count() - 2 }}</div>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="mt-2">
                                                            <a href="{{ route('dashboard.reservations.create', [
                                                                'branch_id' => $branch->id,
                                                                'court_id' => $court->id,
                                                                'date' => $date,
                                                                'start_time' => $timeSlot,
                                                                'end_time' => $endTime
                                                            ]) }}" 
                                                               class="btn btn-sm btn-success">
                                                                <i class="la la-plus"></i> {{ __('dashboard.book_now') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="unavailable-info">
                                                    <div class="badge badge-secondary mb-1">{{ __('dashboard.closed') }}</div>
                                                    <div class="text-muted small">
                                                        <small>{{ __('dashboard.no_coaches_working') }}</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <h5 class="card-title">{{ __('dashboard.legend') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <span class="badge badge-success">{{ __('dashboard.available') }}</span>
                    <small class="text-muted">{{ __('dashboard.available_courts_description') }}</small>
                </div>
                <div class="col-md-3">
                    <span class="badge badge-warning">{{ __('dashboard.reserved') }}</span>
                    <small class="text-muted">{{ __('dashboard.reserved_courts_description') }}</small>
                </div>
                <div class="col-md-3">
                    <span class="badge badge-secondary">{{ __('dashboard.closed') }}</span>
                    <small class="text-muted">{{ __('dashboard.closed_description') }}</small>
                </div>
                <div class="col-md-3">
                    <span class="badge badge-warning">{{ __('dashboard.today') }}</span>
                    <small class="text-muted">{{ __('dashboard.current_day_description') }}</small>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <h6>{{ __('dashboard.coach_legend') }}:</h6>
                    <span class="badge badge-primary">{{ __('dashboard.working_coaches') }}</span>
                    <small class="text-muted">{{ __('dashboard.coaches_available_for_booking') }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        function filterByType(type) {
            const rows = document.querySelectorAll('.timetable-table tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td:not(:first-child)');
                let shouldShow = false;
                
                cells.forEach(cell => {
                    const cellType = cell.getAttribute('data-type');
                    
                    if (type === 'all' || cellType === type) {
                        shouldShow = true;
                    }
                });
                
                row.style.display = shouldShow ? '' : 'none';
            });
            
            // Update button states
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('btn-success', 'btn-primary', 'btn-warning');
                btn.classList.add('btn-outline-success', 'btn-outline-primary', 'btn-outline-warning');
            });
            
            // Highlight active button
            const activeButton = document.getElementById('filter-' + type);
            if (activeButton) {
                activeButton.classList.remove('btn-outline-success', 'btn-outline-primary', 'btn-outline-warning');
                activeButton.classList.add('btn-success', 'btn-primary', 'btn-warning');
            }
        }
        
        // Add event listeners
        document.getElementById('filter-all').addEventListener('click', function() {
            filterByType('all');
        });
        
        document.getElementById('filter-available').addEventListener('click', function() {
            filterByType('available');
        });
        
        document.getElementById('filter-reserved').addEventListener('click', function() {
            filterByType('reserved');
        });
        
        // Initialize with 'all' filter
        filterByType('all');
    });
</script>

<style>
    .timetable-table {
        font-size: 0.85rem;
    }
    
    .reservation-info, .available-info, .unavailable-info {
        padding: 5px;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .available-info {
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .reservation-info {
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .unavailable-info {
        background-color: #e2e3e5;
        border-color: #d6d8db;
    }
    
    .table-warning {
        background-color: #fff3cd !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    
    .small {
        font-size: 0.75rem;
    }
    
    .working-coaches {
        margin-bottom: 8px;
    }
    
    .working-coaches .badge {
        margin-right: 2px;
        margin-bottom: 2px;
        display: inline-block;
    }
</style>
@endsection 