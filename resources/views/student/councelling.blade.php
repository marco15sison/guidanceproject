{{-- resources/views/student/counselling.blade.php --}}
@extends('layouts.student')

@section('title', 'Counselling Services')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Counselling Services</li>
                </ol>
            </nav>
            <div class="card bg-gradient-primary text-white shadow-lg rounded-3 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="service-icon bg-white text-primary rounded-circle p-3 me-3">
                            <i class="fas fa-comments fa-lg"></i>
                        </div>
                        <div>
                            <h2 class="mb-1 fw-bold">Counselling Services</h2>
                            <p class="mb-0 opacity-75">PSU Guidance Management System</p>
                        </div>
                        <div class="ms-auto">
                            <a href="#book-appointment" class="btn btn-light text-primary rounded-pill px-4 py-2 fw-semibold">
                                <i class="far fa-calendar-plus me-1"></i> Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Overview -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <h4 class="border-start border-primary border-4 ps-3 fw-bold">Available Services</h4>
        </div>
        
        <!-- Academic Counselling -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow hover-card border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-3">
                            <i class="fas fa-graduation-cap fa-lg"></i>
                        </div>
                        <h5 class="ms-3 mb-0 fw-bold">Academic Counselling</h5>
                    </div>
                    
                    <p class="text-muted">Get expert guidance on study techniques, time management strategies, and academic performance improvement.</p>
                    
                    <ul class="text-muted small ps-3">
                        <li class="mb-2">Study skills development</li>
                        <li class="mb-2">Course selection assistance</li>
                        <li class="mb-2">Academic progress monitoring</li>
                        <li>Learning style assessment</li>
                    </ul>
                </div>
                <div class="card-footer bg-light">
                    <a href="#" class="btn btn-primary text-white w-100" data-bs-toggle="modal" data-bs-target="#academicCounsellingModal">
                        <i class="fas fa-info-circle me-1"></i> Learn More
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Career Counselling -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow hover-card border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-3">
                            <i class="fas fa-briefcase fa-lg"></i>
                        </div>
                        <h5 class="ms-3 mb-0 fw-bold">Career Counselling</h5>
                    </div>
                    
                    <p class="text-muted">Explore potential career paths, develop professional skills, and prepare for your future career success.</p>
                    
                    <ul class="text-muted small ps-3">
                        <li class="mb-2">Career assessment tests</li>
                        <li class="mb-2">Resume and interview preparation</li>
                        <li class="mb-2">Internship guidance</li>
                        <li>Professional development workshops</li>
                    </ul>
                </div>
                <div class="card-footer bg-light">
                    <a href="#" class="btn btn-primary text-white w-100" data-bs-toggle="modal" data-bs-target="#careerCounsellingModal">
                        <i class="fas fa-info-circle me-1"></i> Learn More
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Personal Counselling -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow hover-card border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-3">
                            <i class="fas fa-heart fa-lg"></i>
                        </div>
                        <h5 class="ms-3 mb-0 fw-bold">Personal Counselling</h5>
                    </div>
                    
                    <p class="text-muted">Confidential support for personal challenges, mental well-being, and emotional health concerns.</p>
                    
                    <ul class="text-muted small ps-3">
                        <li class="mb-2">Stress management techniques</li>
                        <li class="mb-2">Conflict resolution skills</li>
                        <li class="mb-2">Emotional support services</li>
                        <li>Mental health resources</li>
                    </ul>
                </div>
                <div class="card-footer bg-light">
                    <a href="#" class="btn btn-primary text-white w-100" data-bs-toggle="modal" data-bs-target="#personalCounsellingModal">
                        <i class="fas fa-info-circle me-1"></i> Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- My Appointments Section -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="border-start border-primary border-4 ps-3 mb-0 fw-bold">My Appointments</h4>
                <a href="{{ route('student.history') }}" class="btn btn-outline-primary">
                    <i class="fas fa-history me-1"></i> View All History
                </a>
            </div>
        </div>
        
        @if($appointments->count() > 0)
            <div class="row">
                @foreach($appointments as $appointment)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm hover-card border-0">
                            <div class="card-header bg-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' || $appointment->status == 'in_progress' ? 'success' : 'secondary') }} text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold">{{ ucfirst($appointment->service_type) }} Counselling</h5>
                                    <span class="badge bg-white text-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' || $appointment->status == 'in_progress' ? 'success' : 'secondary') }} rounded-pill px-3">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        <p class="mb-0"><strong>Counsellor:</strong> {{ $appointment->counsellor->name }}</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        <p class="mb-0">
                                            <strong>Date:</strong> 
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <p class="mb-0">
                                            <strong>Time:</strong> 
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="d-flex mb-0">
                                        <i class="fas fa-comment-alt text-primary me-2 mt-1"></i>
                                        <div>
                                            <strong>Reason:</strong> 
                                            <p class="mb-0 text-muted small">{{ Str::limit($appointment->reason, 100) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('student.appointmentview', $appointment->id) }}" class="btn btn-primary text-white">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                                
                                @if($appointment->status != 'completed' && $appointment->status != 'cancelled')
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal{{ $appointment->id }}">
                                        <i class="fas fa-times-circle me-1"></i> Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cancel Appointment Modal -->
                    <div class="modal fade" id="cancelAppointmentModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Cancel Appointment</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('student.cancel', $appointment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-info-circle me-2"></i> Are you sure you want to cancel this appointment? This action cannot be undone.
                                        </div>
                                        <div class="mb-3">
                                            <label for="cancellation_reason" class="form-label">Reason for Cancellation</label>
                                            <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" placeholder="Please provide a reason for cancellation..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times-circle me-1"></i> Cancel Appointment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-12">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle fa-lg me-3"></i>
                    <div>
                        <p class="mb-0">You don't have any upcoming appointments. Book a counselling session now to get the support you need!</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Counsellors Section -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <h4 class="border-start border-primary border-4 ps-3 fw-bold">Our Counsellors</h4>
        </div>
        
        <!-- Special Featured Card for MS. NOIME CARLOS -->
        @php
            $noimeCarlos = $counsellors->first(function($counsellor) {
                return stripos($counsellor->name, 'noime carlos') !== false;
            });
        @endphp
        
        @if($noimeCarlos)
            <div class="col-12 mb-4">
                <div class="card shadow-lg border-primary hover-card featured-counsellor-card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-4 mb-md-0">
                                <div class="avatar mx-auto rounded-circle bg-light p-3" style="width: 160px; height: 160px; overflow: hidden;">
                                    @if($noimeCarlos->profile_photo)
                                        <img src="{{ asset('storage/'.$noimeCarlos->profile_photo) }}" alt="{{ $noimeCarlos->name }}" class="img-fluid rounded-circle">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-user-circle fa-5x"></i>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="mt-3 mb-0 fw-bold">{{ $noimeCarlos->name }}</h4>
                                <p class="text-primary fw-semibold mb-2">{{ $noimeCarlos->specialization }}</p>
                                
                                <div class="d-flex justify-content-center flex-wrap">
                                    <span class="badge bg-primary text-white m-1 px-3 py-2 rounded-pill">{{ $noimeCarlos->expertise1 }}</span>
                                    <span class="badge bg-primary text-white m-1 px-3 py-2 rounded-pill">{{ $noimeCarlos->expertise2 }}</span>
                                    <span class="badge bg-primary text-white m-1 px-3 py-2 rounded-pill">{{ $noimeCarlos->expertise3 }}</span>
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">Featured Counsellor</h5>
                                </div>
                                
                                <p class="mb-3">{{ $noimeCarlos->biography }}</p>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 class="border-bottom pb-2 mb-2 fw-bold">Areas of Expertise</h6>
                                        <ul class="list-unstyled">
                                            @foreach(explode("\n", $noimeCarlos->specializations) as $specialization)
                                                @if(!empty(trim($specialization)))
                                                    <li class="mb-2">
                                                        <i class="fas fa-check-circle text-primary me-2"></i> {{ $specialization }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="border-bottom pb-2 mb-2 fw-bold">Availability & Contact</h6>
                                        <p class="mb-2">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i> 
                                            <strong>Days:</strong> {{ str_replace(',', ', ', $noimeCarlos->available_days) }}
                                        </p>
                                        <p class="mb-2">
                                            <i class="fas fa-clock text-primary me-2"></i> 
                                            <strong>Hours:</strong> {{ $noimeCarlos->available_hours }}
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-phone-alt text-primary me-2"></i> 
                                            <strong>Contact:</strong> {{ $noimeCarlos->phone }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2 mt-3">
                                    <a href="#book-appointment" class="btn btn-primary text-white" onclick="selectNoimeCarlos()">
                                        <i class="far fa-calendar-plus me-1"></i> Book Appointment with {{ $noimeCarlos->name }}
                                    </a>
                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#counsellorModal{{ $noimeCarlos->id }}">
                                        <i class="fas fa-id-card me-1"></i> View Full Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Other Counsellors -->
        <div class="row">
            @foreach($counsellors as $counsellor)
                @if(!$noimeCarlos || $counsellor->id != $noimeCarlos->id)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm hover-card border-0 text-center">
                            <div class="card-body">
                                <div class="avatar mx-auto mb-3 rounded-circle bg-light p-2" style="width: 100px; height: 100px; overflow: hidden;">
                                    @if($counsellor->profile_photo)
                                        <img src="{{ asset('storage/'.$counsellor->profile_photo) }}" alt="{{ $counsellor->name }}" class="img-fluid rounded-circle">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-user-circle fa-3x"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <h5 class="mb-1 fw-bold">{{ $counsellor->name }}</h5>
                                <p class="text-muted small mb-2">{{ $counsellor->specialization }}</p>
                                
                                <div class="d-flex justify-content-center flex-wrap mb-3">
                                    <span class="badge bg-primary-subtle text-primary me-2 mb-2">{{ $counsellor->expertise1 }}</span>
                                    <span class="badge bg-primary-subtle text-primary mb-2">{{ $counsellor->expertise2 }}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <a href="#" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#counsellorModal{{ $counsellor->id }}">
                                    <i class="fas fa-id-card me-1"></i> View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Counsellor Profile Modal -->
                <div class="modal fade" id="counsellorModal{{ $counsellor->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title fw-bold"><i class="fas fa-user-md me-2"></i>Counsellor Profile</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                        <div class="avatar mx-auto rounded-circle bg-light p-3 mb-3" style="width: 150px; height: 150px; overflow: hidden;">
                                            @if($counsellor->profile_photo)
                                                <img src="{{ asset('storage/'.$counsellor->profile_photo) }}" alt="{{ $counsellor->name }}" class="img-fluid rounded-circle">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center h-100">
                                                    <i class="fas fa-user-circle fa-5x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <h4 class="mb-1 fw-bold">{{ $counsellor->name }}</h4>
                                        <p class="text-primary fw-semibold mb-3">{{ $counsellor->specialization }}</p>
                                        
                                        <div class="d-flex justify-content-center mb-3 flex-wrap">
                                            <span class="badge bg-primary-subtle text-primary m-1 px-3 py-2 rounded-pill">{{ $counsellor->expertise1 }}</span>
                                            <span class="badge bg-primary-subtle text-primary m-1 px-3 py-2 rounded-pill">{{ $counsellor->expertise2 }}</span>
                                            @if($counsellor->expertise3)
                                                <span class="badge bg-primary-subtle text-primary m-1 px-3 py-2 rounded-pill">{{ $counsellor->expertise3 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8">
                                        <h6 class="border-bottom pb-2 mb-3 fw-bold">Professional Background</h6>
                                        <p>{{ $counsellor->biography }}</p>
                                        
                                        <h6 class="border-bottom pb-2 mb-3 mt-4 fw-bold">Education</h6>
                                        <ul class="list-unstyled">
                                            @foreach(explode("\n", $counsellor->education) as $education)
                                                @if(!empty(trim($education)))
                                                    <li class="mb-2">
                                                        <i class="fas fa-graduation-cap text-primary me-2"></i> {{ $education }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        
                                        <h6 class="border-bottom pb-2 mb-3 mt-4 fw-bold">Specializations</h6>
                                        <ul class="list-unstyled">
                                            @foreach(explode("\n", $counsellor->specializations) as $specialization)
                                                @if(!empty(trim($specialization)))
                                                    <li class="mb-2">
                                                        <i class="fas fa-check-circle text-primary me-2"></i> {{ $specialization }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        
                                        <h6 class="border-bottom pb-2 mb-3 mt-4 fw-bold">Availability</h6>
                                        <p class="mb-2">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i> 
                                            <strong>Days:</strong> {{ str_replace(',', ', ', $counsellor->available_days) }}
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-clock text-primary me-2"></i> 
                                            <strong>Hours:</strong> {{ $counsellor->available_hours }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="#book-appointment" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="selectCounsellor({{ $counsellor->id }})">
                                    <i class="far fa-calendar-plus me-1"></i> Book Appointment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Appointment Booking Section -->
    <div class="row" id="book-appointment">
        <div class="col-12 mb-3">
            <h4 class="border-start border-primary border-4 ps-3 fw-bold">Book an Appointment</h4>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="far fa-calendar-plus me-2"></i> New Appointment Request
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('student.book') }}" method="POST" id="appointmentForm">
                        @csrf
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-check-circle fa-lg"></i>
                                    </div>
                                    <div>
                                        <strong>Success!</strong> {{ session('success') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-exclamation-circle fa-lg"></i>
                                    </div>
                                    <div>
                                        <strong>Error!</strong> {{ session('error') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-primary bg-primary-subtle border-primary">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fas fa-info-circle text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0"><strong>Need professional guidance?</strong> We recommend booking with <strong>MS. NOIME CARLOS</strong> who specializes in all counselling services and is available Monday-Friday.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Counsellor selection - MS. NOIME CARLOS featured -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="counsellor_id" class="form-label fw-bold">Select Counsellor</label>
                                
                                <!-- MS. NOIME CARLOS Recommendation Card -->
                                <div class="card mb-3 border-primary bg-primary-subtle">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            @if($noimeCarlos && $noimeCarlos->profile_photo)
                                                <img src="{{ asset('storage/'.$noimeCarlos->profile_photo) }}" alt="MS. NOIME CARLOS" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user-circle fa-2x"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0 fw-bold">Recommended: MS. NOIME CARLOS</h6>
                                                <p class="mb-0 small">Our dedicated counsellor for all student counselling services</p>
                                            </div>
                                            <div class="ms-auto">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="selectNoimeCarlos()">
                                                    <i class="fas fa-check-circle me-1"></i> Select
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-user-md"></i>
                                    </span>
                                    <select class="form-select @error('counsellor_id') is-invalid @enderror" id="counsellor_id" name="counsellor_id" required>
                                        @if($noimeCarlos)
                                            <option value="{{ $noimeCarlos->id }}" selected data-recommended="true">
                                                {{ $noimeCarlos->name }} - {{ $noimeCarlos->specialization }}
                                            </option>
                                            @foreach($counsellors as $counsellor)
                                                @if($counsellor->id != $noimeCarlos->id)
                                                    <option value="{{ $counsellor->id }}">
                                                        {{ $counsellor->name }} - {{ $counsellor->specialization }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="" disabled selected>Choose a counsellor...</option>
                                            @foreach($counsellors as $counsellor)
                                                <option value="{{ $counsellor->id }}">
                                                    {{ $counsellor->name }} - {{ $counsellor->specialization }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('counsellor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text text-primary">
                                    <i class="fas fa-info-circle me-1"></i> MS. NOIME CARLOS is available Monday-Friday and specializes in all types of counselling services.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Service Type Selection -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="service_type" class="form-label fw-bold">Counselling Type</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-hands-helping"></i>
                                    </span>
                                    <select class="form-select @error('service_type') is-invalid @enderror" id="service_type" name="service_type" required>
                                        <option value="" disabled selected>Select counselling type...</option>
                                        <option value="academic">Academic Counselling</option>
                                        <option value="career">Career Counselling</option>
                                        <option value="personal">Personal Counselling</option>
                                    </select>
                                    @error('service_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Date and Time Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="preferred_date" class="form-label fw-bold">Preferred Date</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date" required min="{{ date('Y-m-d') }}">
                                    @error('preferred_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Select a date (Monday-Friday only)</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="preferred_time" class="form-label fw-bold">Preferred Time</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <select class="form-select @error('preferred_time') is-invalid @enderror" id="preferred_time" name="preferred_time" required>
                                        <option value="" selected disabled>Select time slot</option>
                                        <option value="09:00:00">9:00 AM</option>
                                        <option value="10:00:00">10:00 AM</option>
                                        <option value="11:00:00">11:00 AM</option>
                                        <option value="13:00:00">1:00 PM</option>
                                        <option value="14:00:00">2:00 PM</option>
                                        <option value="15:00:00">3:00 PM</option>
                                        <option value="16:00:00">4:00 PM</option>
                                    </select>
                                    @error('preferred_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Sessions last approximately 60 minutes</div>
                            </div>
                        </div>
                        
                        <!-- Reason for Appointment -->
                        <div class="mb-4">
                            <label for="reason" class="form-label fw-bold">Reason for Appointment</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-comment-alt"></i>
                                </span>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4" placeholder="Please briefly describe your reason for seeking counselling..." required></textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Your information will be kept confidential and only shared with your assigned counsellor</div>
                        </div>
                        
                        <!-- Confidentiality Agreement -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('confidentiality') is-invalid @enderror" type="checkbox" id="confidentiality" name="confidentiality" required>
                                <label class="form-check-label" for="confidentiality">
                                    I understand that while counselling sessions are confidential, counsellors may need to break confidentiality in case of risk of harm to self or others.
                                </label>
                                @error('confidentiality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Submission -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary text-white py-2">
                                <i class="far fa-calendar-check me-1"></i> Submit Appointment Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Appointment Info Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i> Appointment Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Session Duration</h6>
                            <p class="text-muted mb-0 small">Each session lasts approximately 60 minutes</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Available Days</h6>
                            <p class="text-muted mb-0 small">Monday to Friday, 9:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Location</h6>
                            <p class="text-muted mb-0 small">Guidance Office, Administrative Building, 2nd Floor</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Contact Information</h6>
                            <p class="text-muted mb-0 small">guidance@psu.edu.ph | (045) 123-4567</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- MS. NOIME CARLOS Quick Contact Card -->
            @if($noimeCarlos)
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-plus me-2"></i> Need Immediate Help?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar mx-auto mb-3 rounded-circle bg-light p-2" style="width: 80px; height: 80px; overflow: hidden;">
                            @if($noimeCarlos->profile_photo)
                                <img src="{{ asset('storage/'.$noimeCarlos->profile_photo) }}" alt="{{ $noimeCarlos->name }}" class="img-fluid rounded-circle">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-user-circle fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <h5 class="mb-1 fw-bold">{{ $noimeCarlos->name }}</h5>
                        <p class="text-muted mb-0">Available for all counselling services</p>
                    </div>
                    
                    <div class="list-group mb-3">
                        <a href="mailto:{{ $noimeCarlos->email }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <span>{{ $noimeCarlos->email }}</span>
                        </a>
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $noimeCarlos->phone) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-phone text-primary me-3"></i>
                            <span>{{ $noimeCarlos->phone }}</span>
                        </a>
                    </div>
                    
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary text-white" onclick="selectNoimeCarlos()">
                            <i class="fas fa-calendar-plus me-1"></i> Book with MS. NOIME CARLOS
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Service Modals -->
<!-- Academic Counselling Modal -->
<div class="modal fade" id="academicCounsellingModal" tabindex="-1" aria-labelledby="academicCounsellingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="academicCounsellingModalLabel">
                    <i class="fas fa-graduation-cap me-2"></i> Academic Counselling
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">How Academic Counselling Can Help You</h6>
                <p>Academic counselling provides support for students facing challenges in their academic journey. Our counsellors can help with:</p>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Study Skills Development:</strong> Learn effective note-taking, reading comprehension, and exam preparation techniques.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Time Management:</strong> Develop strategies to balance coursework, extracurricular activities, and personal life.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Academic Goal Setting:</strong> Identify clear, achievable academic goals and create actionable plans.
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Learning Style Assessment:</strong> Discover your unique learning style and adapt your study approach.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Course Selection Guidance:</strong> Get advice on choosing courses that align with your career goals.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Academic Probation Support:</strong> Receive specialized support if you're on academic probation.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">What to Expect in an Academic Counselling Session</h6>
                <div class="card mb-4 bg-light border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">1</div>
                                    <div>Assessment of your current academic situation and challenges</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">2</div>
                                    <div>Identification of obstacles to your academic success</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">3</div>
                                    <div>Development of personalized strategies</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">4</div>
                                    <div>Connection with additional academic resources if needed</div>
                                </div>
                                <div class="d-flex">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">5</div>
                                    <div>Creation of a follow-up plan to track your progress</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-primary mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-lightbulb text-primary fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0"><strong>Counsellor Recommendation:</strong> MS. NOIME CARLOS specializes in academic counselling and provides expert guidance for all students.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#book-appointment" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="selectNoimeCarlosWithService('academic')">
                    <i class="fas fa-calendar-plus me-1"></i> Book Academic Counselling
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Career Counselling Modal -->
<div class="modal fade" id="careerCounsellingModal" tabindex="-1" aria-labelledby="careerCounsellingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="careerCounsellingModalLabel">
                    <i class="fas fa-briefcase me-2"></i> Career Counselling
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">How Career Counselling Can Help You</h6>
                <p>Career counselling helps students explore potential career paths and develop professional skills. Our career counsellors can assist with:</p>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Career Assessment:</strong> Take assessments to discover careers that match your interests, values, and skills.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Job Market Information:</strong> Learn about current job market trends and future outlook for different fields.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Resume Building:</strong> Create or improve your resume to highlight your relevant skills and experiences.
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Interview Preparation:</strong> Practice interview techniques and receive feedback to improve your performance.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Internship Guidance:</strong> Get assistance finding and applying for internships related to your field of study.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Networking Skills:</strong> Develop strategies for building professional connections in your desired industry.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">What to Expect in a Career Counselling Session</h6>
                <div class="card mb-4 bg-light border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">1</div>
                                    <div>Discussion of your career interests, goals, and concerns</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">2</div>
                                    <div>Exploration of potential career paths based on your background</div>
                                </div>
                                <div class="d-flex">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">3</div>
                                    <div>Resources provided for further career research</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">4</div>
                                    <div>Assistance with job search strategies and application materials</div>
                                </div>
                                <div class="d-flex">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">5</div>
                                    <div>Development of a career action plan with short and long-term goals</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-primary mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-lightbulb text-primary fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0"><strong>Counsellor Recommendation:</strong> MS. NOIME CARLOS specializes in career counselling and can help you plan your professional future.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#book-appointment" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="selectNoimeCarlosWithService('career')">
                    <i class="fas fa-calendar-plus me-1"></i> Book Career Counselling
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Personal Counselling Modal -->
<div class="modal fade" id="personalCounsellingModal" tabindex="-1" aria-labelledby="personalCounsellingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="personalCounsellingModalLabel">
                    <i class="fas fa-heart me-2"></i> Personal Counselling
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">How Personal Counselling Can Help You</h6>
                <p>Personal counselling provides confidential support for students dealing with personal challenges, mental health concerns, and emotional difficulties. Our counsellors can help with:</p>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Stress Management:</strong> Learn techniques to cope with academic and personal stress.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Emotional Support:</strong> Get support for dealing with anxiety, depression, or other emotional concerns.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Relationship Issues:</strong> Navigate challenges in personal and family relationships.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Adjustment Difficulties:</strong> Receive help adjusting to university life or other major life transitions.
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Crisis Intervention:</strong> Get immediate support during personal crises or emergencies.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Self-Esteem Building:</strong> Develop a healthier self-image and greater self-confidence.
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Grief and Loss Support:</strong> Process feelings related to loss and grief.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <h6 class="border-bottom pb-2 mb-3 fw-bold text-primary">What to Expect in a Personal Counselling Session</h6>
                <div class="card mb-4 bg-light border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">1</div>
                                    <div>Creation of a safe, confidential space for expressing your concerns</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">2</div>
                                    <div>Non-judgmental listening to understand your situation</div>
                                </div>
                                <div class="d-flex">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">3</div>
                                    <div>Help exploring and processing your emotions</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">4</div>
                                    <div>Assistance in developing coping strategies and problem-solving skills</div>
                                </div>
                                <div class="d-flex">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; min-width: 30px;">5</div>
                                    <div>Providing referrals to specialized services if needed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mb-3">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-lock fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0"><strong>Confidentiality Notice:</strong> Personal counselling sessions are confidential. However, confidentiality may be broken if there is a risk of harm to yourself or others, or in cases required by law.</p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-primary mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-lightbulb text-primary fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0"><strong>Counsellor Recommendation:</strong> MS. NOIME CARLOS provides compassionate personal counselling services to support your emotional well-being.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#book-appointment" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="selectNoimeCarlosWithService('personal')">
                    <i class="fas fa-calendar-plus me-1"></i> Book Personal Counselling
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Core styles */
:root {
    --primary: #0d6efd;
    --primary-light: rgba(13, 110, 253, 0.1);
    --secondary: #6c757d;
    --success: #198754;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #0dcaf0;
    --light: #f8f9fa;
    --dark: #212529;
}

/* Service Icons */
.service-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Hover effects */
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
}

/* Background color utilities */
.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1);
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1);
}

.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1);
}

.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1);
}

/* Gradient backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

/* Border utilities */
.border-primary {
    border-color: var(--primary) !important;
}

.border-info {
    border-color: var(--info) !important;
}

/* Highlight recommended counsellor in dropdown */
option[data-recommended="true"] {
    font-weight: bold;
    background-color: var(--primary-light);
}

/* Featured counsellor card */
.featured-counsellor-card {
    position: relative;
    overflow: hidden;
}

.featured-counsellor-card::before {
    content: '';
    position: absolute;
    top: -25px;
    right: -25px;
    width: 100px;
    height: 100px;
    background-color: var(--primary);
    transform: rotate(45deg);
    z-index: 1;
}

.featured-counsellor-card::after {
    content: '\f005'; /* Star icon */
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 10px;
    right: 10px;
    color: white;
    z-index: 2;
}

/* Form focus states */
.form-control:focus,
.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .card-header {
        padding: 0.75rem 1rem;
    }
    
    .service-icon {
        width: 40px;
        height: 40px;
    }
}

/* Accessibility improvements */
.btn {
    font-weight: 500;
}

.badge {
    font-weight: 500;
}

/* Animation for hover cards */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
    }
}

.featured-counsellor-card:hover {
    animation: pulse 1.5s infinite;
}
</style>
@endpush

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const counsellorSelect = document.getElementById('counsellor_id');
    const dateInput = document.getElementById('preferred_date');
    const timeSelect = document.getElementById('preferred_time');
    const serviceTypeSelect = document.getElementById('service_type');
    const appointmentForm = document.getElementById('appointmentForm');
    
    // Form validation and enhanced UX
    appointmentForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Basic form validation
        if (!counsellorSelect.value) {
            highlightInvalidField(counsellorSelect);
            isValid = false;
        }
        
        if (!serviceTypeSelect.value) {
            highlightInvalidField(serviceTypeSelect);
            isValid = false;
        }
        
        if (!dateInput.value) {
            highlightInvalidField(dateInput);
            isValid = false;
        }
        
        if (!timeSelect.value) {
            highlightInvalidField(timeSelect);
            isValid = false;
        }
        
        if (!isValid) {
            event.preventDefault();
            showValidationMessage('Please fill in all required fields');
        }
    });
    
    // Function to highlight invalid fields
    function highlightInvalidField(element) {
        element.classList.add('is-invalid');
        element.addEventListener('change', function() {
            if (element.value) {
                element.classList.remove('is-invalid');
            }
        });
    }
    
    // Function to show validation message
    function showValidationMessage(message) {
        const validationAlert = document.createElement('div');
        validationAlert.className = 'alert alert-danger alert-dismissible fade show mb-4';
        validationAlert.innerHTML = `
            <div class="d-flex">
                <div class="me-3">
                    <i class="fas fa-exclamation-circle fa-lg"></i>
                </div>
                <div>
                    ${message}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        appointmentForm.prepend(validationAlert);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            validationAlert.remove();
        }, 5000);
    }
    
    // Date validation (only weekdays)
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const dayOfWeek = selectedDate.getDay();
        
        // Check if it's a weekend (0 = Sunday, 6 = Saturday)
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            this.setCustomValidity('Please select a weekday (Monday to Friday)');
            showDateValidationMessage('Counselling services are only available on weekdays (Monday to Friday)');
        } else {
            this.setCustomValidity('');
            checkAvailability();
        }
    });
    
    // Show date validation message
    function showDateValidationMessage(message) {
        const dateHelp = dateInput.nextElementSibling;
        dateHelp.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> ${message}</span>`;
        
        setTimeout(() => {
            dateHelp.innerHTML = 'Select a date (Monday-Friday only)';
        }, 5000);
    }
    
    // Function to check availability
    function checkAvailability() {
        const counsellorId = counsellorSelect.value;
        const selectedDate = dateInput.value;
        
        if (counsellorId && selectedDate) {
            // Show loading indicator
            Array.from(timeSelect.options).forEach(option => {
                if (option.value) {
                    option.disabled = true;
                    option.textContent = option.textContent + " (Checking...)";
                }
            });
            
            // Make AJAX request to check availability
            fetch(`{{ route('student.check-availability') }}?counsellor_id=${counsellorId}&date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    // Reset all option texts and disable all slots initially
                    Array.from(timeSelect.options).forEach(option => {
                        if (option.value) {
                            option.disabled = true;
                            option.textContent = option.textContent.replace(" (Checking...)", "");
                        }
                    });
                    
                    // If counsellor is MS. NOIME CARLOS, make all slots available
                    if (isNoimeCarlos(counsellorId)) {
                        Array.from(timeSelect.options).forEach(option => {
                            if (option.value) {
                                option.disabled = false;
                            }
                        });
                    } else {
                        // Enable available time slots based on response
                        data.available_slots.forEach(slot => {
                            const option = Array.from(timeSelect.options).find(opt => opt.value === slot);
                            if (option) {
                                option.disabled = false;
                            }
                        });
                    }
                    
                    // If current selection is now disabled, reset it
                    if (timeSelect.selectedIndex > 0 && timeSelect.options[timeSelect.selectedIndex].disabled) {
                        timeSelect.selectedIndex = 0;
                    }
                    
                    // Update the time slot help text
                    updateTimeSlotHelp(data.available_slots.length);
                })
                .catch(error => {
                    console.error('Error checking availability:', error);
                    // Reset all options
                    Array.from(timeSelect.options).forEach(option => {
                        if (option.value) {
                            option.textContent = option.textContent.replace(" (Checking...)", "");
                        }
                    });
                });
        }
    }
    
    // Update time slot help text
    function updateTimeSlotHelp(availableCount) {
        const timeHelp = timeSelect.nextElementSibling;
        
        if (availableCount === 0) {
            timeHelp.innerHTML = '<span class="text-warning"><i class="fas fa-exclamation-circle me-1"></i> No available slots on this date. Please select another date.</span>';
        } else if (availableCount < 3) {
            timeHelp.innerHTML = '<span class="text-warning"><i class="fas fa-exclamation-circle me-1"></i> Limited slots available!</span>';
        } else {
            timeHelp.innerHTML = 'Sessions last approximately 60 minutes';
        }
    }
    
    // Function to check if selected counsellor is MS. NOIME CARLOS
    function isNoimeCarlos(counsellorId) {
        @if($noimeCarlos)
            return counsellorId == {{ $noimeCarlos->id }};
        @else
            return false;
        @endif
    }
    
    // Add event listeners
    counsellorSelect.addEventListener('change', function() {
        if (dateInput.value) {
            checkAvailability();
        }
    });
    
    // Function to select MS. NOIME CARLOS and scroll to booking form
    window.selectNoimeCarlos = function() {
        @if($noimeCarlos)
            counsellorSelect.value = {{ $noimeCarlos->id }};
            
            // Trigger the change event
            const event = new Event('change');
            counsellorSelect.dispatchEvent(event);
            
            // Smooth scroll to form
            document.getElementById('book-appointment').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
            
            // Focus on service type field
            setTimeout(() => {
                serviceTypeSelect.focus();
            }, 800);
        @endif
    };
    
    // Function to select MS. NOIME CARLOS with specific service type
    window.selectNoimeCarlosWithService = function(serviceType) {
        @if($noimeCarlos)
            counsellorSelect.value = {{ $noimeCarlos->id }};
            serviceTypeSelect.value = serviceType;
            
            // Trigger the change events
            counsellorSelect.dispatchEvent(new Event('change'));
            serviceTypeSelect.dispatchEvent(new Event('change'));
            
            // Smooth scroll to form
            document.getElementById('book-appointment').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
            
            // Focus on date field
            setTimeout(() => {
                dateInput.focus();
            }, 800);
        @endif
    };
    
    // Function to select a specific counsellor
    window.selectCounsellor = function(counsellorId) {
        counsellorSelect.value = counsellorId;
        
        // Trigger the change event
        const event = new Event('change');
        counsellorSelect.dispatchEvent(event);
        
        // Smooth scroll to form
        document.getElementById('book-appointment').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
        
        // Focus on service type field
        setTimeout(() => {
            serviceTypeSelect.focus();
        }, 800);
    };
    
    // Highlight MS. NOIME CARLOS in the select dropdown
    if (counsellorSelect) {
        const options = counsellorSelect.querySelectorAll('option');
        options.forEach(option => {
            if (option.getAttribute('data-recommended') === 'true') {
                option.style.fontWeight = 'bold';
                option.style.backgroundColor = 'rgba(13, 110, 253, 0.1)';
            }
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add auto-scroll to appointment form from page load if URL has hash
    if (window.location.hash === '#book-appointment') {
        setTimeout(() => {
            document.getElementById('book-appointment').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }, 500);
    }
    
    // Highlight featured counsellor card on page load
    const featuredCard = document.querySelector('.featured-counsellor-card');
    if (featuredCard) {
        setTimeout(() => {
            featuredCard.classList.add('pulse');
            setTimeout(() => {
                featuredCard.classList.remove('pulse');
            }, 2000);
        }, 1000);
    }
});
</script>
@endsection
@endsection