@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <a href="{{ route('admin.appointments.student') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Appointments
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Appointment Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Appointment ID</h6>
                            <p>#{{ $appointment->id }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-muted mb-2">Status</h6>
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
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Date & Time</h6>
                            <p>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}<br>
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </p>
                            
                            <h6 class="text-muted mb-2">Counsellor</h6>
                            <p>{{ $appointment->counsellor->name ?? 'Not Assigned' }}</p>
                            
                            <h6 class="text-muted mb-2">Created On</h6>
                            <p>{{ $appointment->created_at->format('F d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Student</h6>
                            <p>
                                @if($appointment->student)
                                    <a href="{{ route('admin.student.profile', $appointment->student->id) }}" class="text-decoration-none">
                                        {{ $appointment->student->name }}
                                    </a>
                                    <br>
                                    {{ $appointment->student->email }}<br>
                                    ID: {{ $appointment->student->id }}
                                @else
                                    <span class="text-muted">Student information not available</span>
                                @endif
                            </p>
                            
                            @if($appointment->status == 'cancelled')
                                <h6 class="text-muted mb-2">Cancellation Reason</h6>
                                <p>{{ $appointment->cancellation_reason ?: 'No reason provided' }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6 class="text-muted mb-2">Reason for Appointment</h6>
                            <div class="p-3 bg-light rounded">
                                {{ $appointment->reason }}
                            </div>
                        </div>
                    </div>
                    
                    @if($appointment->feedback)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="text-muted mb-2">Student Feedback</h6>
                                <div class="p-3 bg-light rounded">
                                    <div class="mb-2">
                                        <strong>Rating:</strong> 
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $appointment->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        ({{ $appointment->rating }}/5)
                                    </div>
                                    <p class="mb-0">{{ $appointment->feedback }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <h6 class="mb-3">Change Appointment Status</h6>
                    <form action="{{ route('admin.appointments.status', $appointment->id) }}" method="POST" class="row g-3 align-items-center">
                        @csrf
                        @method('PUT')
                        <div class="col-md-4">
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="admin_notes" class="form-control" placeholder="Add a note about this status change (optional)">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add Notes</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.notes', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="note" class="form-label">Add a note about this appointment</label>
                            <textarea class="form-control" id="note" name="note" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Note</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Admin Notes History</h5>
                </div>
                <div class="card-body">
                    @if($appointment->notes->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted">No notes have been added yet.</p>
                        </div>
                    @else
                        <div class="timeline">
                            @foreach($appointment->notes as $note)
                                <div class="timeline-item mb-4">
                                    <div class="d-flex">
                                        <div class="timeline-indicator bg-primary rounded-circle me-3" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="fw-bold">{{ $note->admin->name ?? 'Admin' }}</span>
                                                <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                            </div>
                                            <p class="mb-0">{{ $note->note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    @if($appointment->student)
                        <div class="text-center mb-3">
                            @if(isset($appointment->student->profile_picture) && $appointment->student->profile_picture)
                                <img src="{{ asset('storage/' . $appointment->student->profile_picture) }}" alt="{{ $appointment->student->name }}" class="rounded-circle" width="80">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                    <span class="fs-4">{{ substr($appointment->student->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <h5 class="text-center mb-3">{{ $appointment->student->name }}</h5>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Contact Information</h6>
                            <p class="mb-1"><i class="fas fa-envelope me-2 text-primary"></i> {{ $appointment->student->email }}</p>
                            @if(isset($appointment->student->phone) && $appointment->student->phone)
                                <p class="mb-1"><i class="fas fa-phone me-2 text-primary"></i> {{ $appointment->student->phone }}</p>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Student Details</h6>
                            <p class="mb-1"><i class="fas fa-id-card me-2 text-primary"></i> ID: {{ $appointment->student->id }}</p>
                            @if(isset($appointment->student->student_id) && $appointment->student->student_id)
                                <p class="mb-1"><i class="fas fa-graduation-cap me-2 text-primary"></i> Student ID: {{ $appointment->student->student_id }}</p>
                            @endif
                            @if(isset($appointment->student->course) && $appointment->student->course)
                                <p class="mb-1"><i class="fas fa-book me-2 text-primary"></i> Course: {{ $appointment->student->course }}</p>
                            @endif
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('admin.student.profile', $appointment->student->id) }}" class="btn btn-primary">
                                <i class="fas fa-user me-2"></i> View Full Profile
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Student information not available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection