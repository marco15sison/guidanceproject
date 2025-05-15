<!-- resources/views/admin/inventoryrecord.blade.php -->
@extends('layouts.admin')

@section('title', 'Student Inventory Management')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">PSU Student Inventory Management</h4>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('admin.inventoryrecord') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by name, student number, course...">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Course Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.inventoryrecord') }}">All Courses</a></li>
                            @foreach($courseLabels as $course)
                                <li><a class="dropdown-item" href="{{ route('admin.inventoryrecord', ['course' => $course]) }}">{{ $course }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="btn-group ms-2">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Year Level
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.inventoryrecord') }}">All Years</a></li>
                            @foreach($yearLabels as $year)
                                <li><a class="dropdown-item" href="{{ route('admin.inventoryrecord', ['year_level' => $year]) }}">{{ $year }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('admin.inventoryrecord', ['export' => 'excel']) }}" class="btn btn-success ms-2">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                </div>
            </div>

            <!-- Student Inventory Items Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="border-bottom pb-2">Student Inventory Records</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Form ID</th>
                            <th>Student Name</th>
                            <th>Student Number</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Submitted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->form_id }}</td>
                            <td>{{ $inventory->full_name }}</td>
                            <td>{{ $inventory->student_number ?? 'N/A' }}</td>
                            <td>{{ $inventory->course }}</td>
                            <td>{{ $inventory->year_level }}</td>
                            <td>{{ $inventory->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.student.view', ['id' => $inventory->id]) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('student.download', ['id' => $inventory->id]) }}" class="btn btn-outline-success">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $inventory->id }}" data-name="{{ $inventory->full_name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="alert alert-info mb-0">
                                    No student inventory records found.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
    <div>
        Showing {{ $inventories->firstItem() ?? 0 }} to {{ $inventories->lastItem() ?? 0 }} of {{ $inventories->total() ?? 0 }} records
    </div>
    <div>
        {{ $inventories->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

            <!-- Analytics Section -->
            <div class="row mb-4 mt-5">
                <div class="col-md-12">
                    <h5 class="border-bottom pb-2">Student Analytics</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Students by Course</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="courseChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Quick Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-0">{{ $totalStudents }}</h3>
                                            <p class="mb-0">Total Students</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-0">{{ $newStudents }}</h3>
                                            <p class="mb-0">New This Week</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-0">{{ $maleCount }}</h3>
                                            <p class="mb-0">Male</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-0">{{ $femaleCount }}</h3>
                                            <p class="mb-0">Female</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Students by Year Level</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="yearLevelChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Recent Submissions</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @forelse($recentInventories as $recent)
                                <a href="{{ route('admin.student.view', ['id' => $recent->id]) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $recent->full_name }}</h6>
                                        <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ $recent->course }} - {{ $recent->year_level }}</p>
                                </a>
                                @empty
                                <div class="alert alert-info">No recent submissions.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the inventory record for <strong id="studentName"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Delete modal setup - FIXED VERSION
        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const name = button.data('name');
            
            const modal = $(this);
            modal.find('#studentName').text(name);
            
            // Set the form action with the correct ID (fixed to avoid UrlGenerationException)
            modal.find('#deleteForm').attr('action', '/admin/student/' + id);
        });
        
        // Course distribution chart
        const courseCtx = document.getElementById('courseChart').getContext('2d');
        const courseChart = new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($courseLabels) !!},
                datasets: [{
                    label: 'Number of Students',
                    data: {!! json_encode($courseData) !!},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', 
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
        
        // Year level chart
        const yearCtx = document.getElementById('yearLevelChart').getContext('2d');
        const yearChart = new Chart(yearCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($yearLabels) !!},
                datasets: [{
                    data: {!! json_encode($yearData) !!},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
</script>
@endsection