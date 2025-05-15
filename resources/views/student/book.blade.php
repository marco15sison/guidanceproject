{{-- resources/views/student/counselling/appointment_view.blade.php --}}
@extends('layouts.student')

@section('title', 'Appointment Details')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.counceling') }}">Counselling</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.history') }}">History</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{ route('student.feedback') }}">Feedback</a></li> --}}
                    <li class="breadcrumb-item active" aria-current="page">Appointment Details</li>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calendar me-2"></i> Appointment Details
            </h5>
            <span class="badge bg-white text-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' || $appointment->status == 'in_progress' ? 'success' : ($appointment->status == 'completed' ? 'primary' : 'secondary')) }} px-3 py-2">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h6 class="border-bottom pb-2 mb-3">Appointment Information</h6>
                    
                    <div class="mb-3">
                        <p class="mb-1"><strong>Appointment ID:</strong> #{{ $appointment->id }}</p>
                        <p class="mb-1">
                            <strong>Date & Time:</strong> 
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, M d, Y') }} at 
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                        </p>
                        <p class="mb-1"><strong>Service Type:</strong> {{ ucfirst($appointment->service_type) }} Counselling</p>
                        <p class="mb-1"><strong>Status:</strong> 
                            <span class="badge bg-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' || $appointment->status == 'in_progress' ? 'success' : ($appointment->status == 'completed' ? 'primary' : 'secondary')) }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </p>
                        <p class="mb-1"><strong>Requested On:</strong> {{ $appointment->created_at->format('M d, Y h:i A') }}</p>
                        
                        @if($appointment->status == 'cancelled')
                            <p class="mb-1">
                                <strong>Cancelled On:</strong> 
                                {{ $appointment->cancelled_at ? \Carbon\Carbon::parse($appointment->cancelled_at)->format('M d, Y h:i A') : 'N/A' }}
                            </p>
                            <p class="mb-1"><strong>Cancellation Reason:</strong> {{ $appointment->cancellation_reason }}</p>
                        @endif
                    </div>
                    
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Reason for Appointment</h6>
                    <p>{{ $appointment->reason }}</p>
                </div>
                
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">Counsellor Information</h6>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle bg-primary text-white rounded-circle p-3 me-3" style="width: 60px; height: 60px;">
                            @if($appointment->counsellor->profile_photo)
                                <img src="{{ asset('storage/' . $appointment->counsellor->profile_photo) }}" alt="{{ $appointment->counsellor->name }}" class="img-fluid rounded-circle">
                            @else
                                <i class="fas fa-user-circle fa-2x"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $appointment->counsellor->name }}</h5>
                            <p class="text-muted mb-0">{{ $appointment->counsellor->specialization }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-1"><strong>Expertise:</strong> {{ $appointment->counsellor->expertise1 }}, {{ $appointment->counsellor->expertise2 }}</p>
                        
                        <p class="mb-1">
                            <strong>Available Days:</strong> 
                            {{ str_replace(',', ', ', $appointment->counsellor->available_days) }}
                        </p>
                        
                        <p class="mb-0"><strong>Contact:</strong> {{ $appointment->counsellor->email }}</p>
                    </div>
                    
                    @if($appointment->status == 'confirmed')
                        <div class="alert alert-info bg-info-subtle border-info mt-4">
                            <div class="d-flex">
                                <div class="me-2">
                                    <i class="fas fa-info-circle text-info fa-lg"></i>
                                </div>
                                <div>
                                    <p class="mb-0"><strong>Your appointment is confirmed!</strong> Please be at the Guidance Office 5 minutes before your appointment time.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="{{ route('student.history') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to History
            </a>
            
            <div>
                @if(in_array($appointment->status, ['pending', 'confirmed', 'rescheduled']))
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal">
                        <i class="fas fa-times-circle me-1"></i> Cancel Appointment
                    </button>
                @endif
                
                @if($appointment->status == 'completed' && !$appointment->feedback)
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                        <i class="fas fa-star me-1"></i> Provide Feedback
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    @if($appointment->feedback)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-comment-dots me-2"></i> Your Feedback</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <h4 class="mb-3">Rating</h4>
                        <div class="d-flex justify-content-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $appointment->feedback->rating ? 'text-warning' : 'text-muted' }} fa-2x mx-1"></i>
                            @endfor
                        </div>
                        <p class="mt-2 text-muted">{{ $appointment->feedback->rating }}/5 stars</p>
                    </div>
                    <div class="col-md-8">
                        <h4 class="mb-3">Comments</h4>
                        <p>{{ $appointment->feedback->comments ?: 'No comments provided.' }}</p>
                        <p class="text-muted mt-3 mb-0 small">
                            Submitted on {{ $appointment->feedback->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Cancel Appointment Modal -->
<div class="modal fade" id="cancelAppointmentModal" tabindex="-1" aria-hidden="true">
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
                        <label for="cancellation_reason" class="form-label">Reason for Cancellation</label>
                        <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" required></textarea>
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

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Provide Feedback</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('student.feedback', $appointment->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Please rate your experience with this counselling session:</p>
                    
                    <div class="mb-4">
                        <label class="form-label">Rating</label>
                        <div class="rating-container d-flex justify-content-center">
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="comments" class="form-label">Comments (Optional)</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Please share your thoughts about the counselling session..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }
    
    .rating input {
        display: none;
    }
    
    .rating label {
        cursor: pointer;
        font-size: 2rem;
        padding: 0 0.1em;
        color: #ddd;
    }
    
    .rating input:checked ~ label {
        color: #ffbb00;
    }
    
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffbb00;
    }
    
    .bg-info-subtle {
        background-color: rgba(13, 202, 240, 0.1);
    }

    .avatar-circle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize star rating
        const ratingInputs = document.querySelectorAll('.rating input');
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                // You could add additional logic here if needed
            });
        });
    });
</script>
@endsection
@endsection