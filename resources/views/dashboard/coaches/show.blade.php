@extends('dashboard.layouts.app')

@section('title', __('dashboard.coach_details'))

@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.coach_details'),
        'short_description' => __('dashboard.view_coach_information_and_working_times'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.coach_details') }} - {{ $coach->name }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.coaches.edit', ['coach' => $coach]) }}" 
                   class="btn btn-primary font-weight-bolder">
                    <i class="la la-edit"></i>
                    {{ __('dashboard.edit_coach') }}
                </a>
                <a href="{{ route('dashboard.coaches.index') }}" 
                   class="btn btn-secondary font-weight-bolder ml-2">
                    <i class="la la-arrow-left"></i>
                    {{ __('dashboard.back') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Coach Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.id') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $coach->id }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.name') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $coach->name }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.title') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $coach->title }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.level') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $coach->level == 'Team' ? 'primary' : ($coach->level == 'Academy' ? 'success' : 'warning') }}">
                                {{ $coach->level }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.cost_per_hour') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">${{ number_format($coach->cost_per_hour, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.brief') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $coach->brief }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.is_active') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $coach->is_active ? 'success' : 'danger' }}">
                                {{ $coach->is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                            </span>
                        </div>
                    </div>
                    
                    @if($coach->facebook_url)
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.facebook_url') }}:</label>
                        <div class="col-8">
                            <a href="{{ $coach->facebook_url }}" target="_blank" class="form-control-plaintext">{{ $coach->facebook_url }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($coach->instagram_url)
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.instagram_url') }}:</label>
                        <div class="col-8">
                            <a href="{{ $coach->instagram_url }}" target="_blank" class="form-control-plaintext">{{ $coach->instagram_url }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($coach->twitter_url)
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.twitter_url') }}:</label>
                        <div class="col-8">
                            <a href="{{ $coach->twitter_url }}" target="_blank" class="form-control-plaintext">{{ $coach->twitter_url }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($coach->image)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="form-group row">
                        <label class="col-2 col-form-label font-weight-bold">{{ __('dashboard.image') }}:</label>
                        <div class="col-10">
                            <img src="{{ $coach->image_url }}" alt="{{ $coach->name }}" class="img-fluid" style="max-width: 200px;">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Coach Reservations & Time Table -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-calendar"></i> {{ __('dashboard.coach_reservations_time_table') }}
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.reservations.create', ['coach_id' => $coach->id]) }}"
                   class="btn btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>
                    {{ __('dashboard.new_reservation') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @php
                $reservations = $coach->reservations()->with(['player', 'court', 'branch', 'package'])->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();
                $upcomingReservations = $reservations->where('date', '>=', now()->format('Y-m-d'));
                $pastReservations = $reservations->where('date', '<', now()->format('Y-m-d'));
            @endphp

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card card-custom card-stretch">
                        <div class="card-body text-center">
                            <div class="font-size-h1 font-weight-bold text-primary">
                                {{ $reservations->count() }}
                            </div>
                            <div class="font-size-h6 text-muted">{{ __('dashboard.total_reservations') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-custom card-stretch">
                        <div class="card-body text-center">
                            <div class="font-size-h1 font-weight-bold text-success">
                                {{ $upcomingReservations->count() }}
                            </div>
                            <div class="font-size-h6 text-muted">{{ __('dashboard.upcoming_reservations') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-custom card-stretch">
                        <div class="card-body text-center">
                            <div class="font-size-h1 font-weight-bold text-info">
                                {{ $reservations->where('type', 'package_session')->count() }}
                            </div>
                            <div class="font-size-h6 text-muted">{{ __('dashboard.package_sessions') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-custom card-stretch">
                        <div class="card-body text-center">
                            <div class="font-size-h1 font-weight-bold text-warning">
                                ${{ number_format($reservations->sum('price'), 2) }}
                            </div>
                            <div class="font-size-h6 text-muted">{{ __('dashboard.total_earnings') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Reservations -->
            @if($upcomingReservations->count() > 0)
                <div class="mb-4">
                    <h5 class="text-success">
                        <i class="la la-clock"></i> {{ __('dashboard.upcoming_reservations') }} ({{ $upcomingReservations->count() }})
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('dashboard.date') }}</th>
                                    <th>{{ __('dashboard.time') }}</th>
                                    <th>{{ __('dashboard.type') }}</th>
                                    <th>{{ __('dashboard.player') }}</th>
                                    <th>{{ __('dashboard.court') }}</th>
                                    <th>{{ __('dashboard.branch') }}</th>
                                    <th>{{ __('dashboard.package') }}</th>
                                    <th>{{ __('dashboard.duration') }}</th>
                                    <th>{{ __('dashboard.price') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingReservations as $reservation)
                                    <tr class="{{ $reservation->date == now()->format('Y-m-d') ? 'table-warning' : '' }}">
                                        <td>
                                            <span class="badge badge-{{ $reservation->date == now()->format('Y-m-d') ? 'warning' : 'info' }}">
                                                {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->date)->format('l') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</strong>
                                        </td>
                                        <td>
                                            @switch($reservation->type)
                                                @case('package_session')
                                                    <span class="badge badge-success">{{ __('dashboard.package_session') }}</span>
                                                    @break
                                                @case('private_session')
                                                    <span class="badge badge-primary">{{ __('dashboard.private_session') }}</span>
                                                    @break
                                                @case('team_training')
                                                    <span class="badge badge-info">{{ __('dashboard.team_training') }}</span>
                                                    @break
                                                @case('match_play')
                                                    <span class="badge badge-warning">{{ __('dashboard.match_play') }}</span>
                                                    @break
                                                @case('court_rent')
                                                    <span class="badge badge-secondary">{{ __('dashboard.court_rent') }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($reservation->player)
                                                <span class="badge badge-primary">{{ $reservation->player->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $reservation->player->phone }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->court)
                                                <span class="badge badge-info">{{ $reservation->court->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->branch)
                                                <span class="badge badge-secondary">{{ $reservation->branch->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->package)
                                                <span class="badge badge-{{ $reservation->package->type == 'Team' ? 'primary' : ($reservation->package->type == 'Academy' ? 'success' : 'warning') }}">
                                                    {{ $reservation->package->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ $reservation->duration_minutes }} {{ __('dashboard.minutes') }}</span>
                                        </td>
                                        <td>
                                            @if($reservation->price > 0)
                                                <span class="badge badge-success">${{ number_format($reservation->price, 2) }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ __('dashboard.free') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.reservations.show', ['reservation' => $reservation]) }}" 
                                               class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.view') }}">
                                                <i class="la la-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.reservations.edit', ['reservation' => $reservation]) }}" 
                                               class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.edit') }}">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Past Reservations -->
            @if($pastReservations->count() > 0)
                <div class="mb-4">
                    <h5 class="text-muted">
                        <i class="la la-history"></i> {{ __('dashboard.past_reservations') }} ({{ $pastReservations->count() }})
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('dashboard.date') }}</th>
                                    <th>{{ __('dashboard.time') }}</th>
                                    <th>{{ __('dashboard.type') }}</th>
                                    <th>{{ __('dashboard.player') }}</th>
                                    <th>{{ __('dashboard.court') }}</th>
                                    <th>{{ __('dashboard.branch') }}</th>
                                    <th>{{ __('dashboard.package') }}</th>
                                    <th>{{ __('dashboard.duration') }}</th>
                                    <th>{{ __('dashboard.price') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pastReservations->take(10) as $reservation)
                                    <tr>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->date)->format('l') }}</small>
                                        </td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @switch($reservation->type)
                                                @case('package_session')
                                                    <span class="badge badge-success badge-sm">{{ __('dashboard.package_session') }}</span>
                                                    @break
                                                @case('private_session')
                                                    <span class="badge badge-primary badge-sm">{{ __('dashboard.private_session') }}</span>
                                                    @break
                                                @case('team_training')
                                                    <span class="badge badge-info badge-sm">{{ __('dashboard.team_training') }}</span>
                                                    @break
                                                @case('match_play')
                                                    <span class="badge badge-warning badge-sm">{{ __('dashboard.match_play') }}</span>
                                                    @break
                                                @case('court_rent')
                                                    <span class="badge badge-secondary badge-sm">{{ __('dashboard.court_rent') }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($reservation->player)
                                                <small>{{ $reservation->player->name }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->court)
                                                <small>{{ $reservation->court->name }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->branch)
                                                <small>{{ $reservation->branch->name }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->package)
                                                <small>{{ $reservation->package->name }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $reservation->duration_minutes }} {{ __('dashboard.minutes') }}</small>
                                        </td>
                                        <td>
                                            @if($reservation->price > 0)
                                                <small>${{ number_format($reservation->price, 2) }}</small>
                                            @else
                                                <small class="text-muted">{{ __('dashboard.free') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.reservations.show', ['reservation' => $reservation]) }}" 
                                               class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.view') }}">
                                                <i class="la la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($pastReservations->count() > 10)
                        <div class="text-center mt-2">
                            <small class="text-muted">{{ __('dashboard.showing_last_10_reservations') }}</small>
                        </div>
                    @endif
                </div>
            @endif

            @if($reservations->count() == 0)
                <div class="text-center py-5">
                    <i class="la la-calendar font-size-h1 text-muted"></i>
                    <h4 class="text-muted mt-3">{{ __('dashboard.no_reservations') }}</h4>
                    <p class="text-muted">{{ __('dashboard.this_coach_has_no_reservations_yet') }}</p>
                    <a href="{{ route('dashboard.reservations.create', ['coach_id' => $coach->id]) }}" 
                       class="btn btn-primary">
                        <i class="la la-plus"></i>
                        {{ __('dashboard.create_first_reservation') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Working Times Section -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.coach_working_times') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.coach-working-times.create', ['coach_id' => $coach->id]) }}" 
                   class="btn btn-primary font-weight-bolder">
                    <i class="flaticon2-plus-1"></i>
                    {{ __('dashboard.add_working_time') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($coach->workingTimes->count() > 0)
                <div class="row">
                    @php
                        $weekDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    @endphp
                    
                    @foreach($weekDays as $day)
                        @php
                            $dayWorkingTimes = $coach->getWorkingTimesByDay($day);
                        @endphp
                        
                        @if($dayWorkingTimes->count() > 0)
                            <div class="col-md-6 mb-4">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h5 class="card-label">
                                                <span class="badge badge-info">{{ $day }}</span>
                                                <small class="text-muted ml-2">({{ $dayWorkingTimes->count() }} {{ __('dashboard.time_slots') }})</small>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $workingTimesByBranch = $dayWorkingTimes->groupBy('branch_id');
                                        @endphp
                                        
                                        @foreach($workingTimesByBranch as $branchId => $branchWorkingTimes)
                                            <div class="mb-3">
                                                <h6 class="font-weight-bold">
                                                    @if($branchId)
                                                        <span class="badge badge-success">{{ $branchWorkingTimes->first()->branch->name }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ __('dashboard.no_branch') }}</span>
                                                    @endif
                                                </h6>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('dashboard.time') }}</th>
                                                            <th>{{ __('dashboard.duration') }}</th>
                                                            <th>{{ __('dashboard.daily_cost') }}</th>
                                                            <th>{{ __('dashboard.actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($branchWorkingTimes as $workingTime)
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ \Carbon\Carbon::parse($workingTime->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($workingTime->end_time)->format('H:i') }}</strong>
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($workingTime->start_time)->diffInHours(\Carbon\Carbon::parse($workingTime->end_time)) }} {{ __('dashboard.hours') }}</td>
                                                                <td>${{ number_format($coach->cost_per_hour * \Carbon\Carbon::parse($workingTime->start_time)->diffInHours(\Carbon\Carbon::parse($workingTime->end_time)), 2) }}</td>
                                                                <td>
                                                                    <a href="{{ route('dashboard.coach-working-times.edit', ['coachWorkingTime' => $workingTime]) }}" 
                                                                       class="btn btn-sm btn-clean btn-icon" title="{{ __('dashboard.edit') }}">
                                                                        <i class="la la-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('dashboard.coach-working-times.destroy', ['coachWorkingTime' => $workingTime]) }}" 
                                                                          method="POST" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-clean btn-icon" 
                                                                                title="{{ __('dashboard.delete') }}"
                                                                                onclick="return confirm('{{ __('dashboard.are_you_sure') }}')">
                                                                            <i class="la la-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Summary -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body text-center">
                                <div class="font-size-h1 font-weight-bold text-primary">
                                    {{ $coach->workingTimes->count() }}
                                </div>
                                <div class="font-size-h6 text-muted">{{ __('dashboard.working_days') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body text-center">
                                <div class="font-size-h1 font-weight-bold text-success">
                                    {{ $coach->workingTimes->sum(function($wt) { 
                                        return \Carbon\Carbon::parse($wt->start_time)->diffInHours(\Carbon\Carbon::parse($wt->end_time)); 
                                    }) }}
                                </div>
                                <div class="font-size-h6 text-muted">{{ __('dashboard.total_hours_per_week') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body text-center">
                                <div class="font-size-h1 font-weight-bold text-info">
                                    ${{ number_format($coach->workingTimes->sum(function($wt) use ($coach) { 
                                        return $coach->cost_per_hour * \Carbon\Carbon::parse($wt->start_time)->diffInHours(\Carbon\Carbon::parse($wt->end_time)); 
                                    }), 2) }}
                                </div>
                                <div class="font-size-h6 text-muted">{{ __('dashboard.weekly_cost') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="la la-clock font-size-h1 text-muted"></i>
                    <h4 class="text-muted mt-3">{{ __('dashboard.no_working_times') }}</h4>
                    <p class="text-muted">{{ __('dashboard.add_working_times_for_this_coach') }}</p>
                    <a href="{{ route('dashboard.coach-working-times.create', ['coach_id' => $coach->id]) }}" 
                       class="btn btn-primary">
                        <i class="flaticon2-plus-1"></i>
                        {{ __('dashboard.add_first_working_time') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection 