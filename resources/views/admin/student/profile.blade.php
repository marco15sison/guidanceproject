@extends('layouts.admin')

@section('title', 'Student Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($student->profile_picture)
                            <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="{{ $student->name }}" class="rounded-circle img-thumbnail" width="150">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                                <span class="display-4">{{ substr($student->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h4>{{ $student->name }}</h4>
                        <p class="text-muted">Student</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Email:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->email }}
                            </div>
                        </div>
                        @if($student->phone)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Phone:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->phone }}
                            </div>
                        </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">User ID:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->id }}
                            </div>
                        </div>
                        @if($student->student_id)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Student ID:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->student_id }}
                            </div>
                        </div>
                        @endif
                        @if($student->date_of_birth)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Date of Birth:</span>
                            </div>
                            <div class="col-7">
                                {{ \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') }}
                            </div>
                        </div>
                        @endif
                        @if($student->gender)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Gender:</span>
                            </div>
                            <div class="col-7">
                                {{ ucfirst($student->gender) }}
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">Academic Information</h6>
                        @if($student->course)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Course:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->course }}
                            </div>
                        </div>
                        @endif
                        @if($student->year_level)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Year Level:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->year_level }}
                            </div>
                        </div>
                        @endif
                        @if($student->department)
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Department:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->department }}
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div>
                        <h6 class="border-bottom pb-2 mb-3">Account Information</h6>
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Created:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5">
                                <span class="text-muted">Last Updated:</span>
                            </div>
                            <div class="col-7">
                                {{ $student->updated_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Counselling History</h5>
                    <div class="text-end">
                        <span class="badge bg-white text-dark">
                            Total: {{ $appointmentsHistory->count() }} appointments
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($appointmentsHistory->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-calendar.svg') }}" alt="No Appointments" class="img-fluid mb-3" style="max-height: 150px;">
                            <h5>No Appointment History</h5>
                            <p class="text-muted">This student hasn't booked any counselling appointments yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Counsellor</th>
                                        <th>Status</th>
                                        <th>Rating</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointmentsHistory as $appointment)
                                        <tr>
                                            <td>
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}<br>
                                                <span class="badge bg-light text-dark">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                                </span>
                                            </td>
                                            <td>{{ $appointment->counsellor->name ?? 'Not Assigned' }}</td>
                                            <td>
                                                @if($appointment->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($appointment->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($appointment->status == 'completed')
                                                    <span class="badge bg-info">Completed</span>
                                                @elseif($appointment->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($appointment->status == 'rejected')
                                                    <span class="badge bg-secondary">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($appointment->status == 'completed' && isset($appointment->rating) && $appointment->rating)
                                                    <div>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $appointment->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-warning"></i>
                                                            @endif
                                                        @endfor
                                                        ({{ $appointment->rating }}/5)
                                                    </div>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Appointments Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ $appointmentsHistory->count() }}</h3>
                                    <p class="text-muted mb-0">Total Appointments</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ $appointmentsHistory->where('status', 'completed')->count() }}</h3>
                                    <p class="text-muted mb-0">Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ $appointmentsHistory->where('status', 'cancelled')->count() }}</h3>
                                    <p class="text-muted mb-0">Cancelled</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">
                                        @php
                                            $completedWithRating = $appointmentsHistory->where('status', 'completed')->filter(function($appt) {
                                                return isset($appt->rating) && $appt->rating > 0;
                                            });
                                            $avgRating = $completedWithRating->count() > 0 ? round($completedWithRating->avg('rating'), 1) : 'N/A';
                                        @endphp
                                        {{ $avgRating }}
                                    </h3>
                                    <p class="text-muted mb-0">Avg. Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($appointmentsHistory->isNotEmpty())
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="mb-3">Status Distribution</h6>
                                        <canvas id="statusChart" width="100%" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="mb-3">Monthly Appointments</h6>
                                        <canvas id="monthlyChart" width="100%" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($appointmentsHistory->isNotEmpty())
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status distribution chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Pending', 'Approved', 'Completed', 'Cancelled', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $appointmentsHistory->where('status', 'pending')->count() }},
                        {{ $appointmentsHistory->where('status', 'approved')->count() }},
                        {{ $appointmentsHistory->where('status', 'completed')->count() }},
                        {{ $appointmentsHistory->where('status', 'cancelled')->count() }},
                        {{ $appointmentsHistory->where('status', 'rejected')->count() }}
                    ],
                    backgroundColor: [
                        '#ffc107',
                        '#28a745',
                        '#17a2b8',
                        '#dc3545',
                        '#6c757d'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Monthly appointments chart
        @php
            $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(6);
            $monthlyData = [];
            $monthLabels = [];
            
            for ($i = 0; $i < 6; $i++) {
                $month = \Carbon\Carbon::now()->subMonths(5 - $i);
                $monthLabels[] = $month->format('M Y');
                $monthlyData[] = $appointmentsHistory->filter(function($appt) use ($month) {
                    return \Carbon\Carbon::parse($appt->appointment_date)->month == $month->month && 
                           \Carbon\Carbon::parse($appt->appointment_date)->year == $month->year;
                })->count();
            }
        @endphp
        
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Appointments',
                    data: {!! json_encode($monthlyData) !!},
                    backgroundColor: '#4e73df',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endsection
@endif
@endsection