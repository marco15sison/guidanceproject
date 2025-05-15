@extends('layouts.admin')

@section('title', 'System Settings')

@section('page_title')
    <h1 class="h3 mb-0">System Settings</h1>
@endsection

@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="list-group list-group-flush" id="settings-menu">
                    <a href="#general-settings" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                        <i class="fas fa-cog me-2"></i> General Settings
                    </a>
                    <a href="#user-management" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-users-cog me-2"></i> User Management
                    </a>
                    <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-bell me-2"></i> Notifications
                    </a>
                    <a href="#service-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-concierge-bell me-2"></i> Service Settings
                    </a>
                    <a href="#backup-restore" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-database me-2"></i> Backup & Restore
                    </a>
                    <a href="#system-logs" class="list-group-item list-group-item-action" data-bs-toggle="list">
                        <i class="fas fa-list-alt me-2"></i> System Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="tab-content">
            <!-- General Settings -->
            <div class="tab-pane fade show active" id="general-settings">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">System Name</label>
                                <input type="text" class="form-control" value="Guidance Services Admin">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Institution Name</label>
                                <input type="text" class="form-control" value="Sample University">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Time Zone</label>
                                    <select class="form-select">
                                        <option>UTC</option>
                                        <option selected>UTC+8:00 (Philippines)</option>
                                        <option>UTC-5:00 (Eastern Time)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date Format</label>
                                    <select class="form-select">
                                        <option>MM/DD/YYYY</option>
                                        <option selected>DD/MM/YYYY</option>
                                        <option>YYYY-MM-DD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="maintenanceMode">
                                <label class="form-check-label" for="maintenanceMode">Maintenance Mode</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="tab-pane fade" id="user-management">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Faculty Management</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFacultyModal">
                            <i class="fas fa-plus me-1"></i> Add Faculty
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Faculty ID</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->isFaculty())
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->email_address ?? 'N/A' }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-faculty-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editFacultyModal" 
                                                    data-user-id="{{ $user->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-user-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteUserModal" 
                                                    data-user-id="{{ $user->id }}" 
                                                    data-user-name="{{ $user->name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Student Management</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fas fa-plus me-1"></i> Add Student
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Student ID</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->isStudent())
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->email_address ?? 'N/A' }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-student-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editStudentModal" 
                                                    data-user-id="{{ $user->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-user-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteUserModal" 
                                                    data-user-id="{{ $user->id }}" 
                                                    data-user-name="{{ $user->name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings -->
            <div class="tab-pane fade" id="notifications">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Notification Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <h6>Email Notifications</h6>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="emailNewCounseling" checked>
                                <label class="form-check-label" for="emailNewCounseling">New counseling appointments</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="emailNewTest" checked>
                                <label class="form-check-label" for="emailNewTest">New test results</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="emailSystemUpdates" checked>
                                <label class="form-check-label" for="emailSystemUpdates">System updates</label>
                            </div>
                            
                            <h6 class="mt-4">In-App Notifications</h6>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="appNewCounseling" checked>
                                <label class="form-check-label" for="appNewCounseling">New counseling appointments</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="appNewTest" checked>
                                <label class="form-check-label" for="appNewTest">New test results</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="appSystemUpdates">
                                <label class="form-check-label" for="appSystemUpdates">System updates</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Other settings tabs -->
            <div class="tab-pane fade" id="service-settings">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Service Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            Configure service-specific settings here.
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="backup-restore">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Backup & Restore</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            Database backup and restore options will appear here.
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="system-logs">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">System Logs</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            System logs and activity tracking will appear here.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Faculty Modal -->
<div class="modal fade" id="addFacultyModal" tabindex="-1" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFacultyModalLabel">Add New Faculty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/users/store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_type" value="faculty">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="faculty_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="faculty_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Faculty ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="faculty_id" name="email" required>
                        <div class="login-helper mt-1">
                            <i class="fas fa-info-circle"></i>
                            Example: FAC-SC (Faculty ID format)
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="faculty_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="faculty_email" name="email_address">
                    </div>
                    <div class="mb-3">
                        <label for="faculty_password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="faculty_password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="faculty_password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="faculty_password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="faculty_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="faculty_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Faculty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/users/store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_type" value="student">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="student_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="student_id" name="email" required>
                        <div class="login-helper mt-1">
                            <i class="fas fa-info-circle"></i>
                            Example: 22-SC-0216 (Student ID format)
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="student_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="student_email" name="email_address">
                    </div>
                    <div class="mb-3">
                        <label for="student_password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="student_password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="student_password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="student_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="student_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Faculty Modal -->
<div class="modal fade" id="editFacultyModal" tabindex="-1" aria-labelledby="editFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFacultyModalLabel">Edit Faculty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="editFacultyForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_type" value="faculty">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_faculty_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_faculty_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_faculty_id" class="form-label">Faculty ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_faculty_id" name="email" required>
                        <div class="login-helper mt-1">
                            <i class="fas fa-info-circle"></i>
                            Example: FAC-SC (Faculty ID format)
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_faculty_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="edit_faculty_email" name="email_address">
                    </div>
                    <div class="mb-3">
                        <label for="edit_faculty_password" class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
                        <input type="password" class="form-control" id="edit_faculty_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="edit_faculty_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="edit_faculty_password_confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_faculty_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="edit_faculty_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Faculty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="editStudentForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_type" value="student">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_student_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_student_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_student_id" name="email" required>
                        <div class="login-helper mt-1">
                            <i class="fas fa-info-circle"></i>
                            Example: 22-SC-0216 (Student ID format)
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_student_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="edit_student_email" name="email_address">
                    </div>
                    <div class="mb-3">
                        <label for="edit_student_password" class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
                        <input type="password" class="form-control" id="edit_student_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="edit_student_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="edit_student_password_confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_student_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="edit_student_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the user <strong id="delete_user_name"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="#" method="POST" id="deleteUserForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DEBUGGING TIP 1: Add console.log to verify script is loaded
    console.log('Settings page script loaded');
    
    // Handle edit faculty modal
    const editFacultyButtons = document.querySelectorAll('.edit-faculty-btn');
    if (editFacultyButtons.length > 0) {
        editFacultyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                // DEBUGGING TIP 2: Log the faculty ID being edited
                console.log('Editing faculty ID:', userId);
                
                const form = document.getElementById('editFacultyForm');
                
                // Use URL helper instead of route helper to avoid URL generation exception
                const actionUrl = "{{ url('admin/users/update') }}/" + userId;
                form.action = actionUrl;
                // DEBUGGING TIP 3: Log the form action URL
                console.log('Faculty form action set to:', actionUrl);
                
                // Fetch user data via AJAX
                const fetchUrl = "{{ url('admin/users/get') }}/" + userId;
                // DEBUGGING TIP 4: Log the fetch URL
                console.log('Fetching faculty data from:', fetchUrl);
                
                fetch(fetchUrl)
                    .then(response => {
                        // DEBUGGING TIP 5: Check response status
                        console.log('Fetch response status:', response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // DEBUGGING TIP 6: Log the fetched data
                        console.log('Faculty data received:', data);
                        
                        document.getElementById('edit_faculty_name').value = data.name;
                        document.getElementById('edit_faculty_id').value = data.email;
                        document.getElementById('edit_faculty_email').value = data.email_address || '';
                        document.getElementById('edit_faculty_is_active').checked = data.is_active;
                    })
                    .catch(error => {
                        // DEBUGGING TIP 7: Enhanced error logging
                        console.error('Error fetching faculty data:', error);
                        alert('Failed to load faculty data. Please try again. Error: ' + error.message);
                    });
            });
        });
    } else {
        // DEBUGGING TIP 8: Log if no edit faculty buttons found
        console.warn('No edit faculty buttons found');
    }
    
    // Handle edit student modal
    const editStudentButtons = document.querySelectorAll('.edit-student-btn');
    if (editStudentButtons.length > 0) {
        editStudentButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                // DEBUGGING TIP 9: Log the student ID being edited
                console.log('Editing student ID:', userId);
                
                const form = document.getElementById('editStudentForm');
                
                // Use URL helper instead of route helper to avoid URL generation exception
                const actionUrl = "{{ url('admin/users/update') }}/" + userId;
                form.action = actionUrl;
                // DEBUGGING TIP 10: Log the form action URL
                console.log('Student form action set to:', actionUrl);
                
                // Fetch user data via AJAX
                const fetchUrl = "{{ url('admin/users/get') }}/" + userId;
                // DEBUGGING TIP 11: Log the fetch URL
                console.log('Fetching student data from:', fetchUrl);
                
                fetch(fetchUrl)
                    .then(response => {
                        // DEBUGGING TIP 12: Check response status
                        console.log('Fetch response status:', response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // DEBUGGING TIP 13: Log the fetched data
                        console.log('Student data received:', data);
                        
                        document.getElementById('edit_student_name').value = data.name;
                        document.getElementById('edit_student_id').value = data.email;
                        document.getElementById('edit_student_email').value = data.email_address || '';
                        document.getElementById('edit_student_is_active').checked = data.is_active;
                    })
                    .catch(error => {
                        // DEBUGGING TIP 14: Enhanced error logging
                        console.error('Error fetching student data:', error);
                        alert('Failed to load student data. Please try again. Error: ' + error.message);
                    });
            });
        });
    } else {
        // DEBUGGING TIP 15: Log if no edit student buttons found
        console.warn('No edit student buttons found');
    }
    
    // Handle delete user modal (works for both faculty and students)
    const deleteButtons = document.querySelectorAll('.delete-user-btn');
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                
                // DEBUGGING TIP 16: Log deletion info
                console.log('Deleting user:', userName, 'with ID:', userId);
                
                document.getElementById('delete_user_name').textContent = userName;
                
                const form = document.getElementById('deleteUserForm');
                // Use URL helper instead of route helper to avoid URL generation exception
                const deleteUrl = "{{ url('admin/users/delete') }}/" + userId;
                form.action = deleteUrl;
                // DEBUGGING TIP 17: Log the delete form action
                console.log('Delete form action set to:', deleteUrl);
            });
        });
    } else {
        // DEBUGGING TIP 18: Log if no delete buttons found
        console.warn('No delete user buttons found');
    }
    
    // Auto open tab based on hash in URL
    let hash = window.location.hash;
    if (hash) {
        // DEBUGGING TIP 19: Log the hash being used
        console.log('Opening tab based on hash:', hash);
        
        const tab = document.querySelector(`#settings-menu a[href="${hash}"]`);
        if (tab) {
            tab.click();
        } else {
            // DEBUGGING TIP 20: Log if tab with hash not found
            console.warn('No tab found matching hash:', hash);
        }
    }
});
</script>

<style>
/* Add these styles for the login helper */
.login-helper {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.login-helper .fas {
    margin-right: 0.25rem;
    color: #17a2b8;
}
</style>
@endsection