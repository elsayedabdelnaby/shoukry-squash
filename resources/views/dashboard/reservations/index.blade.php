@extends('dashboard.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Reservations</h3>
            <div>
                <a href="{{ route('dashboard.reservations.coach-cost') }}" class="btn btn-info mr-2">
                    <i class="fas fa-calculator"></i> Coach Cost Calculator
                </a>
                <a href="{{ route('dashboard.reservations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Reservation
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($reservations->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Player</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Coach</th>
                            <th>Court</th>
                            <th>Branch</th>
                            <th>Package</th>
                            <th>Subscription</th>
                            <th>Price</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->player->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $reservation->type == 'private_session' ? 'primary' : ($reservation->type == 'team_training' ? 'success' : ($reservation->type == 'match_play' ? 'warning' : ($reservation->type == 'package_session' ? 'info' : 'secondary'))) }}">
                                        @if($reservation->type == 'package_session')
                                            Package Session
                                        @else
                                            {{ ucwords(str_replace('_', ' ', $reservation->type)) }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                                <td>{{ $reservation->duration_minutes }} min</td>
                                <td>{{ $reservation->coach ? $reservation->coach->name : 'N/A' }}</td>
                                <td>{{ $reservation->court ? $reservation->court->name : 'N/A' }}</td>
                                <td>{{ $reservation->branch ? $reservation->branch->name : 'N/A' }}</td>
                                <td>{{ $reservation->package ? $reservation->package->name : 'N/A' }}</td>
                                <td>
                                    @if($reservation->package)
                                        @php
                                            $activeSubscription = \App\Models\Subscription::where('player_id', $reservation->player_id)
                                                ->where('package_id', $reservation->package_id)
                                                ->where('status', 'active')
                                                ->where('start_date', '<=', $reservation->date)
                                                ->where('end_date', '>=', $reservation->date)
                                                ->first();
                                        @endphp
                                        @if($activeSubscription)
                                            <span class="badge badge-success" title="Active subscription until {{ $activeSubscription->end_date->format('d/m/Y') }}">
                                                <i class="fas fa-check"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-warning" title="No active subscription">
                                                <i class="fas fa-exclamation-triangle"></i> No Sub
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge badge-info">N/A</span>
                                    @endif
                                </td>
                                <td>${{ number_format($reservation->price, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $reservation->payment_method == 'cash' ? 'success' : ($reservation->payment_method == 'visa' ? 'primary' : ($reservation->payment_method == 'fawry' ? 'warning' : 'info')) }}">
                                        {{ ucfirst($reservation->payment_method) }}
                                    </span>
                                    @if($reservation->payment_document)
                                        <a href="{{ asset('storage/' . $reservation->payment_document) }}" target="_blank" class="btn btn-sm btn-outline-secondary ml-1">
                                            <i class="fas fa-file"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.reservations.edit', $reservation->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteRecord('{{ route('dashboard.reservations.destroy', $reservation->id) }}', {{ $reservation->id }}, function() { window.location.reload(); })">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $reservations->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No reservations found</h5>
                <p class="text-muted">Create your first reservation to get started.</p>
                <a href="{{ route('dashboard.reservations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Reservation
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 