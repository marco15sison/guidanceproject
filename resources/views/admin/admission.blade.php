<!-- resources/views/admin/admissions/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Admissions')

@section('page_title')
    <h4 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Admissions Management</h4>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Admission Applications</h5>
                    <div>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newAdmissionModal">
                            <i class="fas fa-plus me-1"></i> New Application
                        </button>
                        <div class="btn-group ms-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Applications</a></li>
                                <li><a class="dropdown-item" href="#">Pending Review</a></li>
                                <li><a class="dropdown-item" href="#">Approved</a></li>
                                <li><a class="dropdown-item" href="#">Rejected</a></li>
                                <li><a class="dropdown-item" href="#">Waitlisted</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Applicant Name</th>
                                    <th>Program</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A-2025-001</td>
                                    <td>John Doe</td>
                                    <td>Computer Science</td>
                                    <td>2025-04-05</td>
                                    <td><span class="badge bg-warning">Pending Review</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-success"><i class="fas fa-check"></i></a>
                                            <a href="#" class="btn btn-outline-danger"><i class="fas fa-times"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A-2025-002</td>
                                    <td>Jane Smith</td>
                                    <td>Psychology</td>
                                    <td>2025-04-02</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-file-alt"></i></a>
                                            <a href="#" class="btn btn-outline-info"><i class="fas fa-envelope"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A-2025-003</td>
                                    <td>Michael Johnson</td>
                                    <td>Engineering</td>
                                    <td>2025-03-28</td>
                                    <td><span class="badge bg-danger">Rejected</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-file-alt"></i></a>
                                            <a href="#" class="btn btn-outline-info"><i class="fas fa-envelope"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A-2025-004</td>
                                    <td>Emily Brown</td>
                                    <td>Business Administration</td>
                                    <td>2025-04-10</td>
                                    <td><span class="badge bg-info">Waitlisted</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-success"><i class="fas fa-check"></i></a>
                                            <a href="#" class="btn btn-outline-danger"><i class="fas fa-times"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Total Applications</h6>
                            <h2 class="mb-0">124</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span class="text-muted ms-2">from last month</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Pending Review</h6>
                            <h2 class="mb-0">38</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-danger"><i class="fas fa-arrow-up"></i> 8%</span>
                        <span class="text-muted ms-2">from last week</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Acceptance Rate</h6>
                            <h2 class="mb-0">68%</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success"><i class="fas fa-arrow-up"></i> 5%</span>
                        <span class="text-muted ms-2">from last semester</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Application Modal -->
    <div class="modal fade" id="newAdmissionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Admission Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select">
                                    <option selected disabled>Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Non-binary</option>
                                    <option>Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Program</label>
                            <select class="form-select" required>
                                <option selected disabled>Select Program</option>
                                <option>Computer Science</option>
                                <option>Psychology</option>
                                <option>Engineering</option>
                                <option>Business Administration</option>
                                <option>Medicine</option>
                                <option>Education</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Previous Education</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Documents</label>
                            <input type="file" class="form-control" multiple>
                            <small class="text-muted">Upload transcripts, certificates, ID proof, etc.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Submit Application</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Additional scripts for admissions page if needed
    });
</script>
@endsection
