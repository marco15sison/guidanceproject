{{-- resources/views/student/counselling/history.blade.php --}}
@extends('layouts.student')

@section('title', 'Appointment History')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.councelling') }}">Counselling</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Appointment History</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i> My Appointment History
                </h5>
                <a href="{{ route('student.councelling') }}#book-appointment" class="btn btn-light text-primary">
                    <i class="fas fa-plus-circle me-1"></i> New Appointment
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Counsellor</th>
                            <th>Service Type</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>#{{ $appointment->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white rounded-circle p-2 me-2" style="width: 38px; height: 38px;">
                                            @if($appointment->counsellor->profile_photo)
                                                <img src="{{ asset('storage/' . $appointment->counsellor->profile_photo) }}" alt="{{ $appointment->counsellor->name }}" class="img-fluid rounded-circle">
                                            @else
                                                <i class="fas fa-user"></i>
                                            @endif
                                        </div>
                                        <div>{{ $appointment->counsellor->name }}</div>
                                    </div>
                                </td>
                                <td>{{ ucfirst($appointment->service_type) }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at 
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' || $appointment->status == 'in_progress' ? 'success' : ($appointment->status == 'completed' ? 'primary' : 'secondary')) }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($appointment->status == 'completed')
                                        @if($appointment->feedback)
                                            <div class="d-flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $appointment->feedback->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                                @endfor
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Not Submitted</span>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('student.appointmentview', $appointment->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    
                                    @if(in_array($appointment->status, ['pending', 'confirmed', 'rescheduled']))
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal{{ $appointment->id }}">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            
                            <!-- Cancel Appointment Modal -->
                            <div class="modal fade" id="cancelAppointmentModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Cancel Appointment</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('student.cancel', $appointment->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <p>Are you sure you want to cancel this appointment?</p>
                                                <div class="mb-3">
                                                    <label for="cancellation_reason{{ $appointment->id }}" class="form-label">Reason for Cancellation</label>
                                                    <textarea class="form-control" id="cancellation_reason{{ $appointment->id }}" name="cancellation_reason" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Cancel Appointment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-3">
                                            <i class="fas fa-calendar-times fa-3x text-muted"></i>
                                        </div>
                                        <p class="mb-3">You don't have any appointment history.</p>
                                        <a href="{{ route('student.councelling') }}#book-appointment" class="btn btn-primary">
                                            <i class="fas fa-plus-circle me-1"></i> Book an Appointment
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
@endsection