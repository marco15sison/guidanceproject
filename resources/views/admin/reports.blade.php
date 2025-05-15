@extends('layouts.admin')

@section('title', 'Reports Dashboard')

@section('page_title')
    <h1 class="h3 mb-0">Reports Dashboard</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Guidance Service Reports</h5>
                <div>
                    <button class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i> Export</button>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="reportTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="counseling-tab" data-bs-toggle="tab" href="#counseling" role="tab">Counseling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="placements-tab" data-bs-toggle="tab" href="#placements" role="tab">Job Placements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tests-tab" data-bs-toggle="tab" href="#tests" role="tab">Psychological Tests</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="reportTabsContent">
                    <div class="tab-pane fade show active" id="counseling" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="stat-icon me-3">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Total Counseling Sessions</h6>
                                            <h3 class="mb-0">245</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="stat-icon me-3">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Sessions This Month</h6>
                                            <h3 class="mb-0">32</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="stat-icon me-3">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Avg. Session Duration</h6>
                                            <h3 class="mb-0">45 mins</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Counseling Sessions by Month</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="counselingChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="placements" role="tabpanel">
                        <!-- Job Placements content -->
                        <div class="alert alert-info">
                            Job placement statistics and reports will appear here.
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="tests" role="tabpanel">
                        <!-- Psychological Tests content -->
                        <div class="alert alert-info">
                            Psychological test results and analytics will appear here.
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
    document.addEventListener('DOMContentLoaded', function() {
        // Sample data for the chart
        const ctx = document.getElementById('counselingChart').getContext('2d');
        const counselingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Counseling Sessions',
                    data: [18, 22, 30, 25, 28, 32, 20, 25, 22, 24, 30, 32],
                    backgroundColor: '#4d8bc9',
                    borderColor: '#4d8bc9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection