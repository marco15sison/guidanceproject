<!-- resources/views/admin/psychological/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Psychological Tests')

@section('page_title')
    <h4 class="mb-0">Psychological Tests</h4>
@endsection

@section('content')
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Total Tests</h6>
                            <h3 class="mb-0">24</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clipboard-list"></i>
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
                            <h6 class="card-title text-muted">Tests Taken</h6>
                            <h3 class="mb-0">1,247</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-tasks"></i>
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
                            <h6 class="card-title text-muted">This Month</h6>
                            <h3 class="mb-0">138</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
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
                            <h6 class="card-title text-muted">Pending Reviews</h6>
                            <h3 class="mb-0">27</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-hourglass-half"></i>
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
                    <h5 class="mb-0">Available Tests</h5>
                    <div>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create New Test
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Test ID</th>
                                    <th>Test Name</th>
                                    <th>Category</th>
                                    <th>Questions</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PSY-001</td>
                                    <td>Career Aptitude Test</td>
                                    <td>Career Assessment</td>
                                    <td>45</td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PSY-002</td>
                                    <td>Personality Assessment</td>
                                    <td>Personality</td>
                                    <td>60</td>
                                    <td>40 min</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PSY-003</td>
                                    <td>Intelligence Quotient (IQ)</td>
                                    <td>Intelligence</td>
                                    <td>50</td>
                                    <td>45 min</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PSY-004</td>
                                    <td>Emotional Intelligence (EQ)</td>
                                    <td>Emotional</td>
                                    <td>35</td>
                                    <td>25 min</td>
                                    <td><span class="badge bg-warning">Under Review</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PSY-005</td>
                                    <td>Stress and Anxiety Assessment</td>
                                    <td>Mental Health</td>
                                    <td>30</td>
                                    <td>20 min</td>
                                    <td><span class="badge bg-success">Active</span></td>
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
                    <h5 class="mb-0">Test Analytics</h5>
                </div>
                <div class="card-body">
                    <canvas id="testAnalyticsChart" height="250"></canvas>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Test Results</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Career Aptitude Test</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <small class="text-muted">Emily Chen - Apr 14, 2025</small>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Personality Assessment</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <small class="text-muted">James Wilson - Apr 13, 2025</small>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Intelligence Quotient</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <small class="text-muted">Mark Thompson - Apr 12, 2025</small>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">View All Results</a>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Test Categories</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary p-2">Career Assessment</span>
                        <span class="badge bg-secondary p-2">Personality</span>
                        <span class="badge bg-success p-2">Intelligence</span>
                        <span class="badge bg-info p-2">Emotional</span>
                        <span class="badge bg-warning p-2">Mental Health</span>
                        <span class="badge bg-danger p-2">Leadership</span>
                        <span class="badge bg-dark p-2">Aptitude</span>
                        <span class="badge bg-primary p-2">Communication</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Test Analytics Chart
        var ctx = document.getElementById('testAnalyticsChart').getContext('2d');
        var testAnalyticsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Career', 'Personality', 'Intelligence', 'Emotional', 'Mental Health'],
                datasets: [{
                    data: [35, 25, 15, 15, 10],
                    backgroundColor: [
                        '#4d8bc9',
                        '#6ca36c',
                        '#e6c64c',
                        '#c16969',
                        '#8e5ea2'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>
@endsection