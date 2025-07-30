@extends('dashboard.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            @if($isFromSubscription)
                Create Reservation from Subscription
            @else
                Create New Reservation
            @endif
        </h3>
    </div>
    <div class="card-body">
        @if($isFromSubscription && $activeSubscription)
            <div class="alert alert-info">
                <h6><i class="la la-info-circle"></i> Subscription Information</h6>
                <strong>Player:</strong> {{ $selectedPlayer->name }} ({{ $selectedPlayer->nationality }})<br>
                <strong>Package:</strong> {{ $selectedPackage->name }} ({{ $selectedPackage->type }})<br>
                <strong>Branch:</strong> {{ $activeSubscription->branch ? $activeSubscription->branch->name : 'Not specified' }}<br>
                <strong>Session Type:</strong> Package Session (45 min)<br>
                <strong>Subscription:</strong> Active until {{ $activeSubscription->end_date->format('d/m/Y') }}<br>
                <strong>Price:</strong> Free (covered by subscription)
            </div>
        @endif

        <form action="{{ route('dashboard.reservations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @if($isFromSubscription)
                <!-- Hidden fields for subscription-based reservation -->
                <input type="hidden" name="player_id" value="{{ $selectedPlayer->id }}">
                <input type="hidden" name="package_id" value="{{ $selectedPackage->id }}">
                <input type="hidden" name="is_from_subscription" value="1">
                @if($activeSubscription && $activeSubscription->branch_id)
                    <input type="hidden" name="branch_id" value="{{ $activeSubscription->branch_id }}">
                @endif
                
                <!-- Display player and package info (read-only) -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Player</label>
                            <input type="text" class="form-control" value="{{ $selectedPlayer->name }} ({{ $selectedPlayer->nationality }})" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Package</label>
                            <input type="text" class="form-control" value="{{ $selectedPackage->name }} ({{ $selectedPackage->type }}) - Package Session" readonly>
                        </div>
                    </div>
                </div>
                
                <!-- Display branch info (read-only) for subscription-based reservations -->
                @if($activeSubscription && $activeSubscription->branch)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control" value="{{ $activeSubscription->branch->name }}" readonly>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Full form for regular reservations -->
                <div class="row">
                    <!-- Player Selection -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="player_id">Player *</label>
                            <select name="player_id" id="player_id" class="form-control @error('player_id') is-invalid @enderror" required>
                                <option value="">Select Player</option>
                                @foreach($players as $player)
                                    <option value="{{ $player->id }}" {{ old('player_id') == $player->id ? 'selected' : '' }}>
                                        {{ $player->name }} ({{ $player->nationality }})
                                    </option>
                                @endforeach
                            </select>
                            @error('player_id')
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
                                    <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
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
            @endif

            <div class="row">
                @if($isFromSubscription)
                    <!-- Auto-determined session type for subscription -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Session Type</label>
                            <input type="text" class="form-control" value="Package Session (45 min)" readonly>
                            <input type="hidden" name="type" value="package_session">
                        </div>
                    </div>
                @else
                    <!-- Reservation Type for regular reservations -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Reservation Type *</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="private_session" {{ old('type') == 'private_session' ? 'selected' : '' }}>Private Session (45 min)</option>
                                <option value="team_training" {{ old('type') == 'team_training' ? 'selected' : '' }}>Team Training (45 min)</option>
                                <option value="match_play" {{ old('type') == 'match_play' ? 'selected' : '' }}>Match Play (45 min)</option>
                                <option value="court_rent" {{ old('type') == 'court_rent' ? 'selected' : '' }}>Court Rent (45 min)</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Date -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $selectedDate) }}" required min="{{ date('Y-m-d') }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Start Time -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_time">Start Time *</label>
                        <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $selectedStartTime) }}" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- End Time (Auto-calculated) -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end_time">End Time *</label>
                        <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $selectedEndTime) }}" required readonly>
                        <small class="form-text text-muted">Automatically calculated (45 minutes from start time)</small>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Duration -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duration_minutes">Duration (minutes) *</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror" value="{{ old('duration_minutes', 45) }}" min="45" max="45" required readonly>
                        <small class="form-text text-muted">All sessions are standardized to 45 minutes</small>
                        @error('duration_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @if(!$isFromSubscription)
                <!-- Payment fields only for non-subscription reservations -->
                <div class="row">
                    <!-- Price -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price">Price *</label>
                            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" step="0.01" required>
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
                                <option value="visa" {{ old('payment_method') == 'visa' ? 'selected' : '' }}>Visa</option>
                                <option value="fawry" {{ old('payment_method') == 'fawry' ? 'selected' : '' }}>Fawry</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Payment Document -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment_document">Payment Document</label>
                            <input type="file" name="payment_document" id="payment_document" class="form-control @error('payment_document') is-invalid @enderror">
                            @error('payment_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if(!$isFromSubscription)
                <div class="row">
                    <!-- Branch Selection -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch_id">Branch *</label>
                            <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id', $selectedBranchId) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
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
                                <!-- Courts will be populated dynamically based on selected branch -->
                            </select>
                            @error('court_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @else
                <!-- Court Selection for subscription-based reservations -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="court_id">Court</label>
                            <select name="court_id" id="court_id" class="form-control @error('court_id') is-invalid @enderror">
                                <option value="">Select Court (Optional)</option>
                                @if($activeSubscription && $activeSubscription->branch)
                                    @foreach($activeSubscription->branch->courts as $court)
                                        <option value="{{ $court->id }}" {{ old('court_id', $selectedCourtId) == $court->id ? 'selected' : '' }}>
                                            {{ $court->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('court_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <!-- Coach Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="coach_id">Coach</label>
                        <select name="coach_id" id="coach_id" class="form-control @error('coach_id') is-invalid @enderror">
                            <option value="">Select Coach (Optional)</option>
                            <!-- Coaches will be populated dynamically based on selected branch and day -->
                        </select>
                        @error('coach_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Coach Working Hours Info -->
            <div class="row">
                <div class="col-12">
                    <div id="coach-working-hours" class="alert alert-info" style="display: none;">
                        <h6><i class="la la-clock"></i> Coach Working Hours</h6>
                        <div id="coach-hours-details"></div>
                    </div>
                </div>
            </div>

            @if($isFromSubscription && $selectedPackage)
                <!-- Session Limit Information for subscription-based reservations -->
                <div class="row">
                    <div class="col-12">
                        <div id="session-limit-info" class="alert alert-info" style="display: none;">
                            <h6><i class="la la-info-circle"></i> Session Limit Information</h6>
                            <div id="session-limit-details"></div>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->has('subscription'))
                <div class="alert alert-danger">
                    <i class="la la-exclamation-triangle"></i> {{ $errors->first('subscription') }}
                </div>
            @endif

            @if($errors->has('session_limit'))
                <div class="alert alert-danger">
                    <i class="la la-exclamation-triangle"></i> {{ $errors->first('session_limit') }}
                </div>
            @endif

            @if($errors->has('availability'))
                <div class="alert alert-danger">
                    <i class="la la-exclamation-triangle"></i> {{ $errors->first('availability') }}
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    @if($isFromSubscription)
                        Create Subscription Reservation
                    @else
                        Create Reservation
                    @endif
                </button>
                <a href="{{ route('dashboard.reservations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@if($isFromSubscription && $selectedPackage)
<script>
    // Session limit checking for subscription-based reservations
    document.getElementById('date').addEventListener('change', checkSessionLimit);
    
    function checkSessionLimit() {
        const date = document.getElementById('date').value;
        if (!date) return;

        fetch('{{ route("dashboard.reservations.check-session-limit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                player_id: {{ $selectedPlayer->id }},
                package_id: {{ $selectedPackage->id }},
                date: date
            })
        })
        .then(response => response.json())
        .then(data => {
            const infoDiv = document.getElementById('session-limit-info');
            const detailsDiv = document.getElementById('session-limit-details');
            
            detailsDiv.innerHTML = `
                <strong>Weekly Sessions:</strong> ${data.bookedSessions}/${data.maxSessions}<br>
                <strong>Remaining Sessions:</strong> ${data.remainingSessions}<br>
                <strong>Can Book:</strong> <span class="badge badge-${data.canBook ? 'success' : 'danger'}">${data.canBook ? 'Yes' : 'No'}</span>
            `;
            
            infoDiv.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Check on page load
    checkSessionLimit();
</script>
@endif

<script>
    // Dynamic filtering for courts and coaches
    const branchesData = @json($branchesData);
    const coachesData = @json($coachesData);
    
    // Get day name from date
    function getDayName(dateString) {
        const date = new Date(dateString);
        // Match the database enum values exactly: ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']
        // JavaScript getDay() returns: 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
        // Database enum: Saturday=0, Sunday=1, Monday=2, Tuesday=3, Wednesday=4, Thursday=5, Friday=6
        const dayMap = {
            0: 'Sunday',   // JavaScript Sunday -> Database Sunday
            1: 'Monday',   // JavaScript Monday -> Database Monday  
            2: 'Tuesday',  // JavaScript Tuesday -> Database Tuesday
            3: 'Wednesday', // JavaScript Wednesday -> Database Wednesday
            4: 'Thursday',  // JavaScript Thursday -> Database Thursday
            5: 'Friday',    // JavaScript Friday -> Database Friday
            6: 'Saturday'   // JavaScript Saturday -> Database Saturday
        };
        const dayName = dayMap[date.getDay()];
        console.log('Date:', dateString, 'JavaScript Day:', date.getDay(), 'Mapped Day:', dayName); // Debug
        return dayName;
    }
    
    // Filter courts based on selected branch
    function filterCourts() {
        const branchId = document.getElementById('branch_id').value;
        const courtSelect = document.getElementById('court_id');
        
        // Clear current options
        courtSelect.innerHTML = '<option value="">Select Court (Optional)</option>';
        
        if (branchId) {
            const branch = branchesData.find(b => b.id == branchId);
            if (branch && branch.courts.length > 0) {
                branch.courts.forEach(court => {
                    const option = document.createElement('option');
                    option.value = court.id;
                    option.textContent = court.name;
                    courtSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No courts available for this branch';
                option.disabled = true;
                courtSelect.appendChild(option);
            }
        }
    }
    
    // Filter coaches based on selected branch and day
    function filterCoaches() {
        @if($isFromSubscription && $activeSubscription && $activeSubscription->branch)
            const branchId = {{ $activeSubscription->branch_id }};
        @else
            const branchId = document.getElementById('branch_id').value;
        @endif
        const date = document.getElementById('date').value;
        const startTime = document.getElementById('start_time').value;
        const coachSelect = document.getElementById('coach_id');
        
        console.log('Filtering coaches with:', { branchId, date, startTime }); // Debug
        
        // Clear current options
        coachSelect.innerHTML = '<option value="">Select Coach (Optional)</option>';
        
        if (branchId && date && startTime) {
            const dayName = getDayName(date);
            const availableCoaches = [];
            
            console.log('Looking for coaches on day:', dayName); // Debug
            
            coachesData.forEach(coach => {
                console.log('Checking coach:', coach.name); // Debug
                console.log('Coach working times:', coach.working_times); // Debug
                
                // Check if coach works at this branch on this day
                const workingTimes = coach.working_times.filter(wt => 
                    wt.branch_id == branchId && wt.week_day === dayName
                );
                
                console.log('Working times for this branch/day:', workingTimes); // Debug
                
                if (workingTimes.length > 0) {
                    // Check if the selected start time falls within any working time slot
                    const isAvailable = workingTimes.some(wt => {
                        const selectedTime = startTime;
                        const workingStart = wt.start_time;
                        const workingEnd = wt.end_time;
                        
                        console.log('Checking time:', { selectedTime, workingStart, workingEnd }); // Debug
                        
                        // Check if selected time is within working hours
                        return selectedTime >= workingStart && selectedTime <= workingEnd;
                    });
                    
                    console.log('Coach available:', isAvailable); // Debug
                    
                    if (isAvailable) {
                        availableCoaches.push(coach);
                    }
                }
            });
            
            console.log('Available coaches:', availableCoaches); // Debug
            
            if (availableCoaches.length > 0) {
                availableCoaches.forEach(coach => {
                    const option = document.createElement('option');
                    option.value = coach.id;
                    option.textContent = coach.name;
                    coachSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No coaches available for this branch at selected time';
                option.disabled = true;
                coachSelect.appendChild(option);
            }
        }
    }
    
    // Show coach working hours when coach is selected
    function showCoachWorkingHours() {
        const coachId = document.getElementById('coach_id').value;
        @if($isFromSubscription && $activeSubscription && $activeSubscription->branch)
            const branchId = {{ $activeSubscription->branch_id }};
        @else
            const branchId = document.getElementById('branch_id').value;
        @endif
        const date = document.getElementById('date').value;
        
        const infoDiv = document.getElementById('coach-working-hours');
        const detailsDiv = document.getElementById('coach-hours-details');
        
        if (coachId && branchId && date) {
            const dayName = getDayName(date);
            const coach = coachesData.find(c => c.id == coachId);
            
            if (coach) {
                const workingTimes = coach.working_times.filter(wt => 
                    wt.branch_id == branchId && wt.week_day === dayName
                );
                
                if (workingTimes.length > 0) {
                    let html = `<strong>${coach.name}</strong> working hours on ${dayName}:<br>`;
                    workingTimes.forEach(wt => {
                        html += `<span class="badge badge-success">${wt.start_time} - ${wt.end_time}</span> `;
                    });
                    
                    detailsDiv.innerHTML = html;
                    infoDiv.style.display = 'block';
                } else {
                    infoDiv.style.display = 'none';
                }
            }
        } else {
            infoDiv.style.display = 'none';
        }
    }
    
    // Event listeners
    const branchSelect = document.getElementById('branch_id');
    const dateSelect = document.getElementById('date');
    const startTimeSelect = document.getElementById('start_time');
    const coachSelect = document.getElementById('coach_id');
    
    if (branchSelect) {
        branchSelect.addEventListener('change', function() {
            filterCourts();
            filterCoaches();
        });
    }
    
    if (dateSelect) {
        dateSelect.addEventListener('change', function() {
            filterCoaches();
        });
    }
    
    if (startTimeSelect) {
        startTimeSelect.addEventListener('change', function() {
            filterCoaches();
        });
        
        // Auto-calculate end time based on 45-minute duration
        startTimeSelect.addEventListener('change', function() {
            const startTime = this.value;
            if (startTime) {
                const startDate = new Date(`2000-01-01T${startTime}:00`);
                const endDate = new Date(startDate.getTime() + 45 * 60000); // Add 45 minutes
                
                const endTime = endDate.toTimeString().slice(0, 5); // Format as HH:MM
                const endTimeSelect = document.getElementById('end_time');
                if (endTimeSelect) {
                    endTimeSelect.value = endTime;
                }
            }
        });
    }
    
    if (coachSelect) {
        coachSelect.addEventListener('change', function() {
            showCoachWorkingHours();
        });
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('All coaches data:', coachesData); // Debug - show all coaches and their working times
        
        // Handle pre-selected values from timetable
        @if($selectedBranchId)
            console.log('Pre-selected branch ID:', {{ $selectedBranchId }}); // Debug
            // Pre-populate courts for the selected branch
            const selectedBranch = branchesData.find(b => b.id == {{ $selectedBranchId }});
            if (selectedBranch) {
                const courtSelect = document.getElementById('court_id');
                courtSelect.innerHTML = '<option value="">Select Court (Optional)</option>';
                selectedBranch.courts.forEach(court => {
                    const option = document.createElement('option');
                    option.value = court.id;
                    option.textContent = court.name;
                    @if($selectedCourtId)
                        option.selected = court.id == {{ $selectedCourtId }};
                    @endif
                    courtSelect.appendChild(option);
                });
            }
        @elseif($isFromSubscription && $activeSubscription && $activeSubscription->branch)
            // For subscription-based reservations, pre-populate courts for the subscription's branch
            const subscriptionBranchId = {{ $activeSubscription->branch_id }};
            console.log('Subscription branch ID:', subscriptionBranchId); // Debug
            const subscriptionBranch = branchesData.find(b => b.id == subscriptionBranchId);
            if (subscriptionBranch) {
                const courtSelect = document.getElementById('court_id');
                courtSelect.innerHTML = '<option value="">Select Court (Optional)</option>';
                subscriptionBranch.courts.forEach(court => {
                    const option = document.createElement('option');
                    option.value = court.id;
                    option.textContent = court.name;
                    courtSelect.appendChild(option);
                });
            }
        @else
            filterCourts();
        @endif
        filterCoaches();
    });
</script>
@endsection 