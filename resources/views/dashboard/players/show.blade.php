@extends('dashboard.layouts.app')
@section('title', __('dashboard.player_details'))
@section('subheader')
    @include('dashboard.layouts.partials.sub_header', [
        'module_name' => __('dashboard.player_details'),
        'short_description' => __('dashboard.view_player_information'),
        'breadcrumbs' => [],
    ]);
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('dashboard.player_details') }}
                    <i class="mr-2"></i>
                    <small class=""></small>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.subscriptions.create', ['player_id' => $player->id]) }}"
                   class="btn btn-success font-weight-bolder">
                    <i class="la la-credit-card"></i>
                    {{ __('dashboard.subscribe') }}
                </a>
                <a href="{{ route('dashboard.players.edit', ['player' => $player]) }}"
                   class="btn btn-primary font-weight-bolder ml-2">
                    <i class="la la-edit"></i>
                    {{ __('dashboard.edit') }}
                </a>
                <a href="{{ route('dashboard.players.index') }}"
                   class="btn btn-secondary font-weight-bolder ml-2">
                    <i class="la la-arrow-left"></i>
                    {{ __('dashboard.back') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.id') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $player->id }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.name') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $player->name }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.phone') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $player->phone }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.birth_date') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">
                                {{ $player->birth_date ? \Carbon\Carbon::parse($player->birth_date)->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.age') }}:</label>
                        <div class="col-8">
                            @if($player->age)
                                <span class="badge badge-info">{{ $player->age }} {{ __('dashboard.years') }}</span>
                            @else
                                <span class="form-control-plaintext">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.nationality') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $player->nationality == 'Egyptian' ? 'success' : 'warning' }}">
                                {{ $player->nationality }}
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.gender') }}:</label>
                        <div class="col-8">
                            <span class="badge badge-{{ $player->gender == 'male' ? 'primary' : 'pink' }}">
                                {{ ucfirst($player->gender) }}
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label font-weight-bold">{{ __('dashboard.parents_contact_number') }}:</label>
                        <div class="col-8">
                            <span class="form-control-plaintext">{{ $player->parents_contact_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-custom card-stretch">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">{{ __('dashboard.player_summary') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="font-size-h1 font-weight-bold text-primary">
                                            {{ $player->id }}
                                        </div>
                                        <div class="font-size-h6 text-muted">{{ __('dashboard.player_id') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="font-size-h1 font-weight-bold text-success">
                                            {{ $player->age ?? '-' }}
                                        </div>
                                        <div class="font-size-h6 text-muted">{{ __('dashboard.age_years') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="font-size-h1 font-weight-bold text-info">
                                            {{ $player->nationality }}
                                        </div>
                                        <div class="font-size-h6 text-muted">{{ __('dashboard.nationality') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="font-size-h1 font-weight-bold text-warning">
                                            {{ ucfirst($player->gender) }}
                                        </div>
                                        <div class="font-size-h6 text-muted">{{ __('dashboard.gender') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Status -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-credit-card"></i> {{ __('dashboard.subscription_status') }}
                </h3>
            </div>
        </div>
        <div class="card-body">
            @if($player->hasActiveSubscription())
                @php
                    $activeSubscription = $player->activeSubscription;
                @endphp
                <div class="alert alert-success">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>{{ __('dashboard.active_subscription') }}:</strong><br>
                            <span class="badge badge-primary">{{ $activeSubscription->package->name }}</span>
                            <span class="badge badge-info">{{ $activeSubscription->package->type }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('dashboard.valid_until') }}:</strong><br>
                            <span class="badge badge-{{ $activeSubscription->days_remaining <= 7 ? 'danger' : ($activeSubscription->days_remaining <= 15 ? 'warning' : 'success') }}">
                                {{ $activeSubscription->end_date->format('d/m/Y') }} ({{ $activeSubscription->days_remaining }} {{ __('dashboard.days_remaining') }})
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="la la-exclamation-triangle"></i>
                    {{ __('dashboard.no_active_subscription') }}
                    <a href="{{ route('dashboard.subscriptions.create', ['player_id' => $player->id]) }}" class="btn btn-sm btn-success ml-2">
                        <i class="la la-plus"></i> {{ __('dashboard.subscribe_now') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Player Reservations & Time Table -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-calendar"></i> {{ __('dashboard.player_reservations_time_table') }}
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.reservations.create', ['player_id' => $player->id]) }}"
                   class="btn btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>
                    {{ __('dashboard.new_reservation') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @php
                $reservations = $player->reservations()->with(['coach', 'court', 'branch', 'package'])->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();
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
                            <div class="font-size-h6 text-muted">{{ __('dashboard.total_spent') }}</div>
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
                                    <th>{{ __('dashboard.coach') }}</th>
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
                                            @if($reservation->coach)
                                                <span class="badge badge-primary">{{ $reservation->coach->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $reservation->coach->level }}</small>
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
                                    <th>{{ __('dashboard.coach') }}</th>
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
                                            @if($reservation->coach)
                                                <small>{{ $reservation->coach->name }}</small>
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
                    <p class="text-muted">{{ __('dashboard.this_player_has_no_reservations_yet') }}</p>
                    <a href="{{ route('dashboard.reservations.create', ['player_id' => $player->id]) }}" 
                       class="btn btn-primary">
                        <i class="la la-plus"></i>
                        {{ __('dashboard.create_first_reservation') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Subscriptions -->
    <div class="card card-custom mt-4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    <i class="la la-history"></i> {{ __('dashboard.recent_subscriptions') }}
                </h3>
            </div>
        </div>
        <div class="card-body">
            @php
                $recentSubscriptions = $player->subscriptions()->with('package')->orderBy('created_at', 'desc')->limit(5)->get();
            @endphp
            @if($recentSubscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.package') }}</th>
                                <th>{{ __('dashboard.start_date') }}</th>
                                <th>{{ __('dashboard.end_date') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSubscriptions as $subscription)
                                <tr>
                                    <td>
                                        <span class="badge badge-{{ $subscription->package->type == 'Team' ? 'primary' : ($subscription->package->type == 'Academy' ? 'success' : 'warning') }}">
                                            {{ $subscription->package->name }}
                                        </span>
                                    </td>
                                    <td>{{ $subscription->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $subscription->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($subscription->status === 'active')
                                            <span class="badge badge-success">{{ __('dashboard.active') }}</span>
                                        @elseif($subscription->status === 'expired')
                                            <span class="badge badge-danger">{{ __('dashboard.expired') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('dashboard.cancelled') }}</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($subscription->price_paid, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="la la-info-circle"></i> {{ __('dashboard.no_subscription_history') }}
                </div>
            @endif
        </div>
    </div>
@endsection 