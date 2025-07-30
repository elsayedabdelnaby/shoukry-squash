@extends('dashboard.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Coach Cost Calculation</h3>
    </div>
    <div class="card-body">
        <form id="coachCostForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="coach_id">Select Coach *</label>
                        <select name="coach_id" id="coach_id" class="form-control" required>
                            <option value="">Choose a coach</option>
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="month">Select Month *</label>
                        <input type="month" name="month" id="month" class="form-control" required value="{{ date('Y-m') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calculator"></i> Calculate Cost
                </button>
            </div>
        </form>

        <div id="results" style="display: none;">
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Cost Calculation Results</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong>Coach Name:</strong></td>
                                    <td id="coachName"></td>
                                </tr>
                                <tr>
                                    <td><strong>Month:</strong></td>
                                    <td id="monthDisplay"></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Sessions:</strong></td>
                                    <td id="totalSessions"></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Hours:</strong></td>
                                    <td id="totalHours"></td>
                                </tr>
                                <tr>
                                    <td><strong>Cost Per Hour:</strong></td>
                                    <td id="costPerHour"></td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Total Cost:</strong></td>
                                    <td id="totalCost"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="text-primary">Session Details</h6>
                    <div class="table-responsive">
                        <table class="table table-striped" id="sessionsTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Player</th>
                                    <th>Type</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody id="sessionsTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="loading" style="display: none;" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Calculating costs...</p>
        </div>

        <div id="error" style="display: none;" class="alert alert-danger mt-3">
        </div>
    </div>
</div>

@push('javascript')
<script>
document.getElementById('coachCostForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const coachId = document.getElementById('coach_id').value;
    const month = document.getElementById('month').value;
    
    if (!coachId || !month) {
        alert('Please select both coach and month');
        return;
    }
    
    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';
    document.getElementById('error').style.display = 'none';
    
    // Make AJAX request
    fetch('{{ route("dashboard.reservations.coach-cost-calculation") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            coach_id: coachId,
            month: month
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loading').style.display = 'none';
        
        if (data.error) {
            document.getElementById('error').textContent = data.error;
            document.getElementById('error').style.display = 'block';
            return;
        }
        
        // Display results
        document.getElementById('coachName').textContent = data.coach_name;
        document.getElementById('monthDisplay').textContent = data.month;
        document.getElementById('totalSessions').textContent = data.total_sessions;
        document.getElementById('totalHours').textContent = data.total_hours.toFixed(2) + ' hours';
        document.getElementById('costPerHour').textContent = '$' + data.cost_per_hour.toFixed(2);
        document.getElementById('totalCost').textContent = '$' + data.total_cost.toFixed(2);
        
        // Display sessions
        const sessionsTableBody = document.getElementById('sessionsTableBody');
        sessionsTableBody.innerHTML = '';
        
        if (data.reservations.length === 0) {
            sessionsTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No sessions found for this month</td></tr>';
        } else {
            data.reservations.forEach(session => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(session.date).toLocaleDateString()}</td>
                    <td>${session.start_time} - ${session.end_time}</td>
                    <td>${session.player_name}</td>
                    <td><span class="badge badge-primary">${session.type.replace('_', ' ')}</span></td>
                    <td>45 minutes</td>
                `;
                sessionsTableBody.appendChild(row);
            });
        }
        
        document.getElementById('results').style.display = 'block';
    })
    .catch(error => {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('error').textContent = 'An error occurred while calculating costs. Please try again.';
        document.getElementById('error').style.display = 'block';
        console.error('Error:', error);
    });
});
</script>
@endpush
@endsection 