<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title')
    <h4 class="mb-0 fw-bold">Dashboard</h4>
@endsection

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Students</h6>
                        <h3 class="mb-0">{{ $totalStudents }}</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-{{ $studentGrowth >= 0 ? 'success' : 'danger' }}">
                        <i class="fas fa-arrow-{{ $studentGrowth >= 0 ? 'up' : 'down' }} me-1"></i>{{ abs($studentGrowth) }}%
                    </span>
                    <span class="text-muted ms-2">Since last month</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Counseling Sessions</h6>
                        <h3 class="mb-0">186</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success"><i class="fas fa-arrow-up me-1"></i>8%</span>
                    <span class="text-muted ms-2">Since last month</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="col-lg-8 mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Student Registration Trend</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartTimeRange" data-bs-toggle="dropdown">
                        This Year
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="chartTimeRange">
                        <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="registrationChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Service Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="serviceDistributionChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities and Calendar -->
    <div class="col-lg-8 mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Activities</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">New student admission</h6>
                            <small class="text-muted">3 mins ago</small>
                        </div>
                        <p class="mb-1">John Smith was admitted to the Guidance program.</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Counseling session scheduled</h6>
                            <small class="text-muted">1 hour ago</small>
                        </div>
                        <p class="mb-1">Group counseling session #G-122 scheduled for tomorrow.</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Psychological test completed</h6>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                        <p class="mb-1">5 students completed their career aptitude tests.</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">New job opportunity</h6>
                            <small class="text-muted">5 hours ago</small>
                        </div>
                        <p class="mb-1">TechCorp posted 3 new internship opportunities.</p>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Inventory update</h6>
                            <small class="text-muted">Yesterday</small>
                        </div>
                        <p class="mb-1">15 new counseling handbooks added to inventory.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Upcoming Schedule</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Career Fair</h6>
                                <small class="text-muted">Today, 10:00 AM</small>
                            </div>
                            <span class="badge bg-primary">Today</span>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Group Counseling</h6>
                                <small class="text-muted">Today, 2:00 PM</small>
                            </div>
                            <span class="badge bg-primary">Today</span>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Aptitude Test</h6>
                                <small class="text-muted">Tomorrow, 9:00 AM</small>
                            </div>
                            <span class="badge bg-info">Tomorrow</span>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Staff Meeting</h6>
                                <small class="text-muted">Apr 16, 11:00 AM</small>
                            </div>
                            <span class="badge bg-secondary">Upcoming</span>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Workshop: Stress Management</h6>
                                <small class="text-muted">Apr 18, 1:00 PM</small>
                            </div>
                            <span class="badge bg-secondary">Upcoming</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Registration Trend Chart
        var registrationCtx = document.getElementById('registrationChart').getContext('2d');
        var registrationChart = new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Student Registrations',
                    data: [120, 150, 180, 190, 210, 250, 240, 260, 230, 270, 290, 350],
                    borderColor: '#4d8bc9',
                    backgroundColor: 'rgba(77, 139, 201, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Service Distribution Chart
        var serviceCtx = document.getElementById('serviceDistributionChart').getContext('2d');
        var serviceChart = new Chart(serviceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Inventory', 'Counseling', 'Job Placement', 'Psychological Tests', 'Information', 'Admissions'],
                datasets: [{
                    data: [40, 35, 15, 20, 10, 20],
                    backgroundColor: [
                        '#4d8bc9',
                        '#4caf50',
                        '#ff9800',
                        '#9c27b0',
                        '#f44336',
                        '#ff9800'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection