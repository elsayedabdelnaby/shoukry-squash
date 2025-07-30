@extends('dashboard.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Reservation Details</h3>
            <div>
                <a href="{{ route('dashboard.reservations.edit', $reservation->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('dashboard.reservations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Basic Information</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Reservation ID:</strong></td>
                        <td>#{{ $reservation->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Player:</strong></td>
                        <td>{{ $reservation->player->name }} ({{ $reservation->player->nationality }})</td>
                    </tr>
                    <tr>
                        <td><strong>Type:</strong></td>
                        <td>
                            <span class="badge badge-{{ $reservation->type == 'private_session' ? 'primary' : ($reservation->type == 'team_training' ? 'success' : ($reservation->type == 'match_play' ? 'warning' : 'info')) }}">
                                {{ ucwords(str_replace('_', ' ', $reservation->type)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date)->format('l, F d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Time:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Duration:</strong></td>
                        <td>{{ $reservation->duration_minutes }} minutes</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Service Details</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Coach:</strong></td>
                        <td>{{ $reservation->coach ? $reservation->coach->name : 'Not Assigned' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Court:</strong></td>
                        <td>{{ $reservation->court ? $reservation->court->name : 'Not Assigned' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Branch:</strong></td>
                        <td>{{ $reservation->branch ? $reservation->branch->name : 'Not Assigned' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Package:</strong></td>
                        <td>{{ $reservation->package ? $reservation->package->name : 'Not Assigned' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Payment Information</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Price:</strong></td>
                        <td><span class="h5 text-success">${{ number_format($reservation->price, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>
                            <span class="badge badge-{{ $reservation->payment_method == 'cash' ? 'success' : ($reservation->payment_method == 'visa' ? 'primary' : ($reservation->payment_method == 'fawry' ? 'warning' : 'info')) }}">
                                {{ ucfirst($reservation->payment_method) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Payment Document:</strong></td>
                        <td>
                            @if($reservation->payment_document)
                                <a href="{{ asset('storage/' . $reservation->payment_document) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-file"></i> View Document
                                </a>
                            @else
                                <span class="text-muted">No document uploaded</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Player Information</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $reservation->player->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $reservation->player->phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nationality:</strong></td>
                        <td>{{ $reservation->player->nationality }}</td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong></td>
                        <td>{{ $reservation->player->age }} years old</td>
                    </tr>
                    <tr>
                        <td><strong>Gender:</strong></td>
                        <td>{{ ucfirst($reservation->player->gender) }}</td>
                    </tr>
                    @if($reservation->player->parents_contact_number)
                        <tr>
                            <td><strong>Parents Contact:</strong></td>
                            <td>{{ $reservation->player->parents_contact_number }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                <h5 class="text-primary mb-3">Timeline</h5>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Reservation Created</h6>
                            <p class="timeline-text">{{ $reservation->created_at->format('l, F d, Y \a\t H:i') }}</p>
                        </div>
                    </div>
                    @if($reservation->updated_at != $reservation->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Reservation Updated</h6>
                                <p class="timeline-text">{{ $reservation->updated_at->format('l, F d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Scheduled Session</h6>
                            <p class="timeline-text">{{ \Carbon\Carbon::parse($reservation->date)->format('l, F d, Y') }} at {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-left: 10px;
}

.timeline-title {
    margin: 0 0 5px 0;
    font-weight: 600;
}

.timeline-text {
    margin: 0;
    color: #6c757d;
}
</style>
@endsection 