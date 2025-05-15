<!-- resources/views/admin/job-placement/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Job Placement')

@section('page_title')
    <h4 class="mb-0">Job Placement</h4>
@endsection

@section('content')
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Total Placements</h6>
                            <h3 class="mb-0">187</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Open Positions</h6>
                            <h3 class="mb-0">56</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Active Applications</h6>
                            <h3 class="mb-0">92</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Partner Companies</h6>
                            <h3 class="mb-0">43</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Job Listings</h5>
                    <div>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Job
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Position</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Applications</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>JP-2025-042</td>
                                    <td>Software Developer</td>
                                    <td>TechCorp Inc.</td>
                                    <td>San Francisco, CA</td>
                                    <td>12</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>JP-2025-041</td>
                                    <td>Marketing Specialist</td>
                                    <td>Global Media Group</td>
                                    <td>New York, NY</td>
                                    <td>8</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>JP-2025-040</td>
                                    <td>Human Resources Manager</td>
                                    <td>Innovative Solutions</td>
                                    <td>Chicago, IL</td>
                                    <td>5</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>JP-2025-039</td>
                                    <td>Data Analyst</td>
                                    <td>DataDrive Analytics</td>
                                    <td>Remote</td>
                                    <td>15</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>JP-2025-038</td>
                                    <td>Project Manager</td>
                                    <td>BuildRight Construction</td>
                                    <td>Dallas, TX</td>
                                    <td>7</td>
                                    <td><span class="badge bg-warning">Closing Soon</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Placement Statistics</h5>
                </div>
                <div class="card-body">
                    <canvas id="placementChart" height="260"></canvas>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top Companies</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="company-icon me-3 bg-light rounded p-2">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">TechCorp Inc.</h6>
                                    <small class="text-muted">15 open positions</small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="company-icon me-3 bg-light rounded p-2">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Global Media Group</h6>
                                    <small class="text-muted">8 open positions</small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="company-icon me-3 bg-light rounded p-2">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">DataDrive Analytics</h6>
                                    <small class="text-muted">6 open positions</small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Placements</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">John Davis</h6>
                                    <small class="text-muted">Software Engineer at TechCorp</small>
                                </div>
                                <span class="text-muted small">Today</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Sarah Johnson</h6>
                                    <small class="text-muted">Marketing Manager at Global Media</small>
                                </div>
                                <span class="text-muted small">Yesterday</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Michael Wong</h6>
                                    <small class="text-muted">Data Analyst at DataDrive</small>
                                </div>
                                <span class="text-muted small">Apr 10, 2025</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">View All Placements</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Placement Chart
        var ctx = document.getElementById('placementChart').getContext('2d');
        var placementChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                    label: 'Placements',
                    data: [12, 15, 18, 14],
                    backgroundColor: '#4d8bc9',
                    borderColor: '#4d8bc9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 25
                    }
                }
            }
        });
    });
</script>
@endsection