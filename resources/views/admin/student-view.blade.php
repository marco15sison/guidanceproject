<!-- resources/views/admin/student-view.blade.php -->
@extends('layouts.admin')

@section('title', 'Student Inventory Details')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Student Inventory Details</h4>
            <div>
                <a href="{{ route('admin.inventoryrecord') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
                <a href="{{ route('student.download', ['id' => $inventory->id]) }}" class="btn btn-outline-light btn-sm ms-2">
                    <i class="fas fa-file-pdf me-1"></i> Download PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 text-center">
                    <div class="card">
                        <div class="card-body">
                            @if($inventory->photo && Storage::disk('public')->exists($inventory->photo))
                                <img src="{{ asset('storage/' . $inventory->photo) }}" alt="Student Photo" class="img-fluid rounded mb-3" style="max-height: 200px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                                    <span class="text-muted">No Photo</span>
                                </div>
                            @endif
                            <h5 class="card-title mb-1">{{ $inventory->full_name }}</h5>
                            <p class="card-text text-muted mb-0">{{ $inventory->student_number ?? 'No Student ID' }}</p>
                            <p class="card-text">
                                <span class="badge bg-primary">{{ $inventory->course }}</span>
                                <span class="badge bg-secondary">{{ $inventory->year_level }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fs-6">Form Information</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Form ID:</strong> {{ $inventory->form_id }}</p>
                            <p class="mb-1"><strong>Submitted:</strong> {{ $inventory->created_at->format('M d, Y g:i A') }}</p>
                            <p class="mb-0"><strong>Last Updated:</strong> {{ $inventory->updated_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-9">
                    <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">Personal Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab">Education</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab">Family</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="health-tab" data-bs-toggle="tab" data-bs-target="#health" type="button" role="tab">Health</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="interests-tab" data-bs-toggle="tab" data-bs-target="#interests" type="button" role="tab">Interests & Hobbies</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="interview-tab" data-bs-toggle="tab" data-bs-target="#interview" type="button" role="tab">Interview</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content p-3 border border-top-0 rounded-bottom mb-4" id="studentTabContent">
                        <!-- Personal Information Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Gender:</strong> {{ $inventory->gender }}</p>
                                    <p class="mb-1"><strong>Date of Birth:</strong> {{ $inventory->date_of_birth ? date('F d, Y', strtotime($inventory->date_of_birth)) : 'N/A' }}</p>
                                    <p class="mb-1"><strong>Place of Birth:</strong> {{ $inventory->place_of_birth ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Age:</strong> {{ $inventory->age ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Civil Status:</strong> {{ $inventory->civil_status ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Religion:</strong> {{ $inventory->religion ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Citizenship:</strong> {{ $inventory->citizenship ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Contact Number:</strong> {{ $inventory->contact_number ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $inventory->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <p class="mb-1"><strong>Residential Address:</strong> {{ $inventory->residential_address ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Permanent Address:</strong> {{ $inventory->permanent_address ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Places where student stays:</strong> 
                                        @if(is_array($data['staying_place'] ?? null) && count($data['staying_place']) > 0)
                                            {{ implode(', ', $data['staying_place']) }}
                                        @else
                                            {{ $inventory->staying_place ?? 'N/A' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Educational Background Tab -->
                        <div class="tab-pane fade" id="education" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>High School:</strong> {{ $inventory->high_school_name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Type of High School:</strong> {{ $inventory->high_school_type ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>School Address:</strong> {{ $inventory->previous_school_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Year Graduated:</strong> {{ $inventory->year_graduated ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>High School GPA:</strong> {{ $inventory->high_school_gpa ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Previous College/University:</strong> {{ $inventory->previous_college_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <p class="mb-1"><strong>Honors/Special Awards:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $inventory->awards ?? 'None specified' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Family Information Tab -->
                        <div class="tab-pane fade" id="family" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="border-bottom pb-2">Father's Information</h6>
                                    <p class="mb-1"><strong>Name:</strong> {{ $inventory->father_name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Educational Attainment:</strong> {{ $inventory->father_education ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Occupation:</strong> {{ $inventory->father_occupation ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Age:</strong> {{ $inventory->father_age ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="border-bottom pb-2">Mother's Information</h6>
                                    <p class="mb-1"><strong>Name:</strong> {{ $inventory->mother_name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Educational Attainment:</strong> {{ $inventory->mother_education ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Occupation:</strong> {{ $inventory->mother_occupation ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Age:</strong> {{ $inventory->mother_age ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <h6 class="border-bottom pb-2">Guardian's Information</h6>
                                    <p class="mb-1"><strong>Name:</strong> {{ $inventory->guardian_name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Relationship:</strong> {{ $inventory->guardian_relationship ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Occupation:</strong> {{ $inventory->guardian_occupation ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Contact Number:</strong> {{ $inventory->guardian_contact ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="border-bottom pb-2">Family Details</h6>
                                    <p class="mb-1"><strong>Parent's Marital Status:</strong> {{ $inventory->parent_marital_status ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Number of Children:</strong> {{ $inventory->number_of_children ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Birth Order:</strong> {{ $inventory->birth_order ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Who finances schooling:</strong> 
                                        @if(is_array($data['finances'] ?? null) && count($data['finances']) > 0)
                                            {{ implode(', ', $data['finances']) }}
                                        @else
                                            {{ $inventory->finances ?? 'N/A' }}
                                        @endif
                                    </p>
                                    <p class="mb-1"><strong>Monthly Family Income:</strong> {{ $inventory->monthly_income ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Weekly Allowance:</strong> {{ $inventory->weekly_allowance ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Health Information Tab -->
                        <div class="tab-pane fade" id="health" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Academic Health Problems:</strong>
                                        @if(is_array($data['academic_health'] ?? null) && count($data['academic_health']) > 0)
                                            {{ implode(', ', $data['academic_health']) }}
                                        @else
                                            {{ $inventory->academic_health ?? 'None specified' }}
                                        @endif
                                    </p>
                                    <p class="mb-1"><strong>Physical Health Concerns:</strong> {{ $inventory->physical_health ?? 'None specified' }}</p>
                                    <p class="mb-1"><strong>Psychological Consultation:</strong>
                                        @if(is_array($data['psych_consultation'] ?? null) && count($data['psych_consultation']) > 0)
                                            {{ implode(', ', $data['psych_consultation']) }}
                                        @else
                                            {{ $inventory->psych_consultation ?? 'None specified' }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Allergies:</strong> {{ $inventory->allergies ?? 'None specified' }}</p>
                                    <p class="mb-1"><strong>Medications:</strong> {{ $inventory->medications ?? 'None specified' }}</p>
                                    <p class="mb-1"><strong>Emergency Contact:</strong> {{ $inventory->emergency_contact ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Interests and Hobbies Tab -->
                        <div class="tab-pane fade" id="interests" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Favorite Subjects:</strong> {{ $inventory->fav_subjects ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Least Favorite Subjects:</strong> {{ $inventory->least_subjects ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Hobbies:</strong> {{ $inventory->hobbies ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>Skills and Talents:</strong> {{ $inventory->skills ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Extra-curricular Activities:</strong> {{ $inventory->extra_curricular ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Intake Interview Tab -->
                        <div class="tab-pane fade" id="interview" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>My father:</strong> {{ $inventory->father ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My mother:</strong> {{ $inventory->mother ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My family:</strong> {{ $inventory->family ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My siblings:</strong> {{ $inventory->siblings ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My childhood:</strong> {{ $inventory->childhood ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My friends:</strong> {{ $inventory->friends ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-1"><strong>My school:</strong> {{ $inventory->school ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My dream:</strong> {{ $inventory->dream ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My weakness:</strong> {{ $inventory->weakness ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>I am afraid:</strong> {{ $inventory->fear ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>My strength:</strong> {{ $inventory->strength ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>In 5 years, I see myself:</strong> {{ $inventory->future_vision ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="btn-group">
                        <a href="{{ route('admin.inventoryrecord') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                        <a href="{{ route('student.download', ['id' => $inventory->id]) }}" class="btn btn-primary">
                            <i class="fas fa-file-pdf me-1"></i> Download PDF
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">
                            <i class="fas fa-trash me-1"></i> Delete Record
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRecordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the inventory record for <strong>{{ $inventory->full_name }}</strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <form action="/admin/student/{{ $inventory->id }}" method="POST">
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
        // Initialize Bootstrap tabs
        var tabEl = document.querySelector('#studentTabs a[data-bs-toggle="tab"]')
        var tab = new bootstrap.Tab(tabEl)
        tab.show()
    });
</script>
@endsection