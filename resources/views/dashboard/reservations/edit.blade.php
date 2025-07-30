@extends('dashboard.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Reservation</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.reservations.update', $reservation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Player Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="player_id">Player *</label>
                        <select name="player_id" id="player_id" class="form-control @error('player_id') is-invalid @enderror" required>
                            <option value="">Select Player</option>
                            @foreach($players as $player)
                                <option value="{{ $player->id }}" {{ (old('player_id', $reservation->player_id) == $player->id) ? 'selected' : '' }}>
                                    {{ $player->name }} ({{ $player->nationality }})
                                </option>
                            @endforeach
                        </select>
                        @error('player_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Reservation Type -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Reservation Type *</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="private_session" {{ (old('type', $reservation->type) == 'private_session') ? 'selected' : '' }}>Private Session (45 min)</option>
                            <option value="team_training" {{ (old('type', $reservation->type) == 'team_training') ? 'selected' : '' }}>Team Training (45 min)</option>
                            <option value="match_play" {{ (old('type', $reservation->type) == 'match_play') ? 'selected' : '' }}>Match Play (45 min)</option>
                            <option value="court_rent" {{ (old('type', $reservation->type) == 'court_rent') ? 'selected' : '' }}>Court Rent (45 min)</option>
                            <option value="package_session" {{ (old('type', $reservation->type) == 'package_session') ? 'selected' : '' }}>Package Session (45 min)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Date -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $reservation->date) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Start Time -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_time">Start Time *</label>
                        <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $reservation->start_time) }}" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- End Time -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end_time">End Time *</label>
                        <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $reservation->end_time) }}" required>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Duration -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duration_minutes">Duration (minutes) *</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror" value="{{ old('duration_minutes', $reservation->duration_minutes) }}" min="45" max="45" required readonly>
                        <small class="form-text text-muted">All sessions are standardized to 45 minutes</small>
                        @error('duration_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Price -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price">Price *</label>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $reservation->price) }}" min="0" step="0.01" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="payment_method">Payment Method *</label>
                        <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                            <option value="">Select Payment Method</option>
                            <option value="visa" {{ (old('payment_method', $reservation->payment_method) == 'visa') ? 'selected' : '' }}>Visa</option>
                            <option value="fawry" {{ (old('payment_method', $reservation->payment_method) == 'fawry') ? 'selected' : '' }}>Fawry</option>
                            <option value="cash" {{ (old('payment_method', $reservation->payment_method) == 'cash') ? 'selected' : '' }}>Cash</option>
                            <option value="transfer" {{ (old('payment_method', $reservation->payment_method) == 'transfer') ? 'selected' : '' }}>Transfer</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Coach Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="coach_id">Coach</label>
                        <select name="coach_id" id="coach_id" class="form-control @error('coach_id') is-invalid @enderror">
                            <option value="">Select Coach (Optional)</option>
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}" {{ (old('coach_id', $reservation->coach_id) == $coach->id) ? 'selected' : '' }}>
                                    {{ $coach->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('coach_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Court Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="court_id">Court</label>
                        <select name="court_id" id="court_id" class="form-control @error('court_id') is-invalid @enderror">
                            <option value="">Select Court (Optional)</option>
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}" {{ (old('court_id', $reservation->court_id) == $court->id) ? 'selected' : '' }}>
                                    {{ $court->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('court_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Branch Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                            <option value="">Select Branch (Optional)</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ (old('branch_id', $reservation->branch_id) == $branch->id) ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Package Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="package_id">Package</label>
                        <select name="package_id" id="package_id" class="form-control @error('package_id') is-invalid @enderror">
                            <option value="">Select Package (Optional)</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ (old('package_id', $reservation->package_id) == $package->id) ? 'selected' : '' }}>
                                    {{ $package->name }} - ${{ number_format($package->price_egyptian, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('package_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Document Upload -->
            <div class="form-group">
                <label for="payment_document">Payment Document</label>
                @if($reservation->payment_document)
                    <div class="mb-2">
                        <strong>Current Document:</strong>
                        <a href="{{ asset('storage/' . $reservation->payment_document) }}" target="_blank" class="btn btn-sm btn-outline-info ml-2">
                            <i class="fas fa-file"></i> View Current Document
                        </a>
                    </div>
                @endif
                <input type="file" name="payment_document" id="payment_document" class="form-control @error('payment_document') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Upload new payment receipt or proof (PDF, JPG, PNG - Max 2MB). Leave empty to keep current document.</small>
                @error('payment_document')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Availability Error Display -->
            @if($errors->has('availability'))
                <div class="alert alert-danger">
                    {{ $errors->first('availability') }}
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Reservation
                </button>
                <a href="{{ route('dashboard.reservations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </form>
    </div>
</div>

@push('javascript')
<script>
    // Auto-calculate duration when start and end time change
    document.getElementById('start_time').addEventListener('change', calculateDuration);
    document.getElementById('end_time').addEventListener('change', calculateDuration);

    function calculateDuration() {
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;
        
        if (startTime && endTime) {
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(`2000-01-01T${endTime}`);
            
            if (end > start) {
                const diffMs = end - start;
                const diffMins = Math.round(diffMs / 60000);
                document.getElementById('duration_minutes').value = diffMins;
            }
        }
    }

    // Auto-calculate end time when start time changes (fixed 45 minutes)
    document.getElementById('start_time').addEventListener('change', function() {
        const startTime = this.value;
        if (startTime) {
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(start.getTime() + 45 * 60000); // 45 minutes
            const endTimeStr = end.toTimeString().slice(0, 5);
            document.getElementById('end_time').value = endTimeStr;
        }
    });
</script>
@endpush
@endsection 