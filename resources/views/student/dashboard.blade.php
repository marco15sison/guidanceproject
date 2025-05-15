@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')
<div class="container py-4">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-sm rounded-3 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="mb-1">Welcome, {{ Auth::user()->name ?? 'Student' }}</h2>
                            <p class="mb-0 opacity-75">Pangasinan State University Guindace Management</p>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                <i class="fas fa-calendar-alt me-1"></i> May 7, 2025
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Cards Row -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h4 class="border-start border-primary border-4 ps-3">Student Services</h4>
        </div>
        
        <!-- Inventory Service Card -->
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="service-icon bg-primary-subtle text-primary rounded-circle p-3">
                            <i class="fas fa-clipboard-list fa-lg"></i>
                        </div>
                        <h5 class="ms-3 mb-0">Inventory Management</h5>
                    </div>
                    
                    @if(isset($form))
                        <div class="alert alert-success bg-success-subtle border-success mb-3">
                            <div class="d-flex">
                                <div class="me-2">
                                    <i class="fas fa-check-circle text-success fa-lg"></i>
                                </div>
                                <div>
                                    <p class="mb-1"><strong>Status:</strong> Submitted</p>
                                    <p class="mb-0 small">Last Updated: April 30, 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit Form
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-file-pdf me-1"></i> Download PDF
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning bg-warning-subtle border-warning mb-3">
                            <div class="d-flex">
                                <div class="me-2">
                                    <i class="fas fa-exclamation-triangle text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <p class="mb-1"><strong>Status:</strong> Not Submitted</p>
                                    <p class="mb-0 small">Due by: May 15, 2025</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('student.inventory_form') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Fill Inventory Form
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Counseling Service Card -->
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="service-icon bg-info-subtle text-info rounded-circle p-3">
                            <i class="fas fa-comments fa-lg"></i>
                        </div>
                        <h5 class="ms-3 mb-0">Counseling Services</h5>
                    </div>
                    
                    <p class="text-muted">Access mental health support, academic guidance, and personal counseling.</p>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-check text-info me-2"></i>
                            <span>Next Available: <strong>May 8, 2025, 10:00 AM</strong></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tie text-info me-2"></i>
                            <span>Counselor: <strong>Dr. Maria Santos</strong></span>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <a href="{{ route('student.councelling') }}" class="btn btn-info text-white">
                            <i class="far fa-calendar-plus me-1"></i> Book Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Job Placement Service Card -->
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="service-icon bg-success-subtle text-success rounded-circle p-3">
                            <i class="fas fa-briefcase fa-lg"></i>
                        </div>
                        <h5 class="ms-3 mb-0">Job Placement</h5>
                    </div>
                    
                    <p class="text-muted">Discover internships and job opportunities aligned with your field of study.</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-success mb-2">5 New Opportunities</span>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-building text-success me-2"></i>
                            <span>Latest: <strong>IT Intern at PH TechHub</strong></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-business-time text-success me-2"></i>
                            <span>Career Fair: <strong>May 20, 2025</strong></span>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-search me-1"></i> Browse Opportunities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Announcements and Quick Links Row -->
    <div class="row">
        <!-- Announcements Section -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white py-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-bullhorn me-2"></i> Important Announcements
                        </h5>
                        <a href="#" class="btn btn-outline-light btn-sm ms-auto">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-3">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-0 text-primary">End of Semester Requirements</h6>
                                <span class="badge bg-primary rounded-pill">New</span>
                            </div>
                            <p class="mb-1">All students must complete their inventory forms and clear their library accounts before the end of the semester.</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="far fa-clock me-1"></i> May 5, 2025
                                <i class="fas fa-user ms-3 me-1"></i> Registrar's Office
                            </div>
                        </div>
                        
                        <div class="list-group-item p-3">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-0 text-danger">System Maintenance Notice</h6>
                                <span class="badge bg-danger rounded-pill">Important</span>
                            </div>
                            <p class="mb-1">The student portal will be down for maintenance on May 15, 2025 from 10:00 PM to 2:00 AM. Please plan accordingly.</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="far fa-clock me-1"></i> May 3, 2025
                                <i class="fas fa-user ms-3 me-1"></i> IT Department
                            </div>
                        </div>
                        
                        <div class="list-group-item p-3">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-0 text-success">Upcoming Career Fair</h6>
                                <span class="badge bg-success rounded-pill">Event</span>
                            </div>
                            <p class="mb-1">Don't miss the Spring Career Fair with over 30 companies offering internships and full-time positions. Prepare your resumes!</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="far fa-clock me-1"></i> May 1, 2025
                                <i class="fas fa-user ms-3 me-1"></i> Career Services
                            </div>
                        </div>
                        
                        <div class="list-group-item p-3">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-0 text-info">Free Mental Health Workshop</h6>
                                <span class="badge bg-info rounded-pill">Workshop</span>
                            </div>
                            <p class="mb-1">Join us for a free stress management workshop on May 10. Learn techniques to balance academic pressures and personal well-being.</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="far fa-clock me-1"></i> April 29, 2025
                                <i class="fas fa-user ms-3 me-1"></i> Student Affairs Office
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Links and Notifications -->
        <div class="col-md-4">
            <!-- Quick Links Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-link me-2"></i> Quick Links
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-user-circle text-primary me-3"></i> Student Profile
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-book text-primary me-3"></i> Course Information
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-primary me-3"></i> Academic Calendar
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-graduation-cap text-primary me-3"></i> Graduation Requirements
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-id-card text-primary me-3"></i> ID Verification
                        </a>
                    </ul>
                </div>
            </div>
            
            <!-- Notifications Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white py-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </h5>
                        <span class="badge bg-light text-danger ms-2">3 New</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-3 bg-light-hover">
                            <div class="d-flex align-items-center">
                                <div class="notification-icon bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">New Message from Professor</h6>
                                    <p class="mb-0 small text-muted">Feedback on your midterm project is now available.</p>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item p-3 bg-light-hover">
                            <div class="d-flex align-items-center">
                                <div class="notification-icon bg-success text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Assignment Submission Confirmed</h6>
                                    <p class="mb-0 small text-muted">Your Science project has been submitted successfully.</p>
                                    <small class="text-muted">Yesterday</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="list-group-item p-3 bg-light-hover">
                            <div class="d-flex align-items-center">
                                <div class="notification-icon bg-warning text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Upcoming Deadline</h6>
                                    <p class="mb-0 small text-muted">Research paper due in 3 days. Don't forget to submit!</p>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a href="#" class="btn btn-sm btn-outline-secondary d-block">View All Notifications</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.service-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hover-card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.bg-light-hover:hover {
    background-color: rgba(0, 0, 0, 0.03);
}

.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1);
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1);
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

.border-primary {
    border-color: #0d6efd !important;
}

.border-info {
    border-color: #0dcaf0 !important;
}

.border-success {
    border-color: #198754 !important;
}

.border-warning {
    border-color: #ffc107 !important;
}

.border-danger {
    border-color: #dc3545 !important;
}
</style>
@endsection