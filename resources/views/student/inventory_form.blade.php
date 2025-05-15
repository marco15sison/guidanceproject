@extends('layouts.student')

@section('title', 'Student Inventory Form')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">PSU Student Inventory Form</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                
                <!-- Personal Information Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="border-bottom pb-2">Personal Information</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Upload 2x2 ID Photo</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="photo">
                            <small class="text-muted">Max 2 MB</small>
                            @error('photo')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="student_number" class="form-label">Student Number</label>
                        <input type="text" class="form-control @error('student_number') is-invalid @enderror" id="student_number" name="student_number" value="{{ old('student_number') }}">
                        @error('student_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Complete Name (Last Name, First Name, M.I.) *</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                        @error('full_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="course" class="form-label">Course *</label>
                        <select class="form-select @error('course') is-invalid @enderror" id="course" name="course" required>
                            <option value="">Select Course</option>
                            <option value="" {{ old('course') == 'BS Hospitality Management' ? 'selected' : '' }}>BS Hospitality Management</option>
                            <option value="Bachelor of Elementary Education" {{ old('course') == 'Bachelor of Elementary Education' ? 'selected' : '' }}>Bachelor of Elementary Education</option>
                            <option value="BSE Major in Filipino" {{ old('course') == 'BSE Major in Filipino' ? 'selected' : '' }}>BSE Major in Filipino</option>
                            <option value="Bachelor of Technology and Livehood Education" {{ old('course') == 'Bachelor of Technology and Livehood Education' ? 'selected' : '' }}>Bachelor of Technology and Livehood Education</option>
                            <option value="Bachelor Business Administration" {{ old('course') == 'Bachelor Business Administration' ? 'selected' : '' }}>Bachelor Business Administration</option>
                            <option value="BS Information Technology" {{ old('course') == 'BS Information Technology' ? 'selected' : '' }}>BS Information Technology</option>
                            <option value="Bachelor Office Administration" {{ old('course') == 'Bachelor Office Administration' ? 'selected' : '' }}>Bachelor Office Administration</option>
                        </select>
                        @error('course')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="year_level" class="form-label">Year Level *</label>
                        <select class="form-select @error('year_level') is-invalid @enderror" id="year_level" name="year_level" required>
                            <option value="">Select Year Level</option>
                            <option value="First Year" {{ old('year_level') == 'First Year' ? 'selected' : '' }}>First Year</option>
                            <option value="Second Year" {{ old('year_level') == 'Second Year' ? 'selected' : '' }}>Second Year</option>
                            <option value="Third Year" {{ old('year_level') == 'Third Year' ? 'selected' : '' }}>Third Year</option>
                            <option value="Fourth Year" {{ old('year_level') == 'Fourth Year' ? 'selected' : '' }}>Fourth Year</option>
                            {{-- <option value="Fifth Year" {{ old('year_level') == 'Fifth Year' ? 'selected' : '' }}>Fifth Year</option> --}}
                        </select>
                        @error('year_level')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                        <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}">
                        @error('place_of_birth')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Gender *</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender_male" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender_female" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age') }}">
                        @error('age')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Civil Status *</label>
                        <select class="form-select @error('civil_status') is-invalid @enderror" id="civil_status" name="civil_status" required>
                            <option value="">Select Civil Status</option>
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                            <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        </select>
                        @error('civil_status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="religion" class="form-label">Religion</label>
                        <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" value="{{ old('religion') }}">
                        @error('religion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="citizenship" class="form-label">Citizenship</label>
                        <input type="text" class="form-control @error('citizenship') is-invalid @enderror" id="citizenship" name="citizenship" value="{{ old('citizenship') }}">
                        @error('citizenship')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                        @error('contact_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="residential_address" class="form-label">Residential Address</label>
                        <input type="text" class="form-control @error('residential_address') is-invalid @enderror" id="residential_address" name="residential_address" value="{{ old('residential_address') }}">
                        @error('residential_address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="permanent_address" class="form-label">Permanent Address</label>
                        <input type="text" class="form-control @error('permanent_address') is-invalid @enderror" id="permanent_address" name="permanent_address" value="{{ old('permanent_address') }}">
                        @error('permanent_address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Place where you are staying (Please check ALL applicable to you) *</label>
                        <div class="mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="staying_place[]" id="staying_place_home" value="Home with parents" {{ (is_array(old('staying_place')) && in_array('Home with parents', old('staying_place'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="staying_place_home">Home with parents</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="staying_place[]" id="staying_place_friends" value="Staying with friends" {{ (is_array(old('staying_place')) && in_array('Staying with friends', old('staying_place'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="staying_place_friends">Staying with friends</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="staying_place[]" id="staying_place_private" value="Private House" {{ (is_array(old('staying_place')) && in_array('Private House', old('staying_place'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="staying_place_private">Private House</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="staying_place[]" id="staying_place_apartment" value="Apartment" {{ (is_array(old('staying_place')) && in_array('Apartment', old('staying_place'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="staying_place_apartment">Apartment</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="staying_place[]" id="staying_place_dorm" value="Dormitory / Boarding House" {{ (is_array(old('staying_place')) && in_array('Dormitory / Boarding House', old('staying_place'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="staying_place_dorm">Dormitory / Boarding House</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="staying_place[]" id="staying_place_relative" value="Staying with a relative" {{ (is_array(old('staying_place')) && in_array('Staying with a relative', old('staying_place'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="staying_place_relative">Staying with a relative</label>
                            </div>
                            @error('staying_place')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Educational Background Section -->
                <div class="row mb-4 mt-4">
                    <div class="col-md-12">
                        <h5 class="border-bottom pb-2">Educational Background</h5>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="high_school_name" class="form-label">Name of High School</label>
                        <input type="text" class="form-control @error('high_school_name') is-invalid @enderror" id="high_school_name" name="high_school_name" value="{{ old('high_school_name') }}">
                        @error('high_school_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Type of high school attended *</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('high_school_type') is-invalid @enderror" type="radio" name="high_school_type" id="high_school_type_private" value="Private school" {{ old('high_school_type') == 'Private school' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="high_school_type_private">Private school</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('high_school_type') is-invalid @enderror" type="radio" name="high_school_type" id="high_school_type_public" value="Public school" {{ old('high_school_type') == 'Public school' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="high_school_type_public">Public school</label>
                            </div>
                            @error('high_school_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="previous_school_address" class="form-label">Address of previous school</label>
                        <input type="text" class="form-control @error('previous_school_address') is-invalid @enderror" id="previous_school_address" name="previous_school_address" value="{{ old('previous_school_address') }}">
                        @error('previous_school_address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="year_graduated" class="form-label">Year graduated</label>
                        <input type="text" class="form-control @error('year_graduated') is-invalid @enderror" id="year_graduated" name="year_graduated" value="{{ old('year_graduated') }}">
                        @error('year_graduated')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="high_school_gpa" class="form-label">High School GPA</label>
                        <input type="text" class="form-control @error('high_school_gpa') is-invalid @enderror" id="high_school_gpa" name="high_school_gpa" value="{{ old('high_school_gpa') }}">
                        @error('high_school_gpa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="awards" class="form-label">Honors/Special Awards received</label>
                        <textarea class="form-control @error('awards') is-invalid @enderror" id="awards" name="awards" rows="2">{{ old('awards') }}</textarea>
                        @error('awards')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="previous_college_name" class="form-label">Name of College/University (*For transferees only)</label>
                        <input type="text" class="form-control @error('previous_college_name') is-invalid @enderror" id="previous_college_name" name="previous_college_name" value="{{ old('previous_college_name') }}">
                        @error('previous_college_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Family Information Section -->
                <div class="row mb-4 mt-4">
                    <div class="col-md-12">
                        <h5 class="border-bottom pb-2">Family Information</h5>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="father_name" class="form-label">Name of Father</label>
                        <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name') }}">
                        @error('father_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="father_education" class="form-label">Father's Educational Attainment</label>
                        <input type="text" class="form-control @error('father_education') is-invalid @enderror" id="father_education" name="father_education" value="{{ old('father_education') }}">
                        @error('father_education')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="father_occupation" class="form-label">Father's Occupation</label>
                        <input type="text" class="form-control @error('father_occupation') is-invalid @enderror" id="father_occupation" name="father_occupation" value="{{ old('father_occupation') }}">
                        @error('father_occupation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="father_age" class="form-label">Father's Age</label>
                        <input type="number" class="form-control @error('father_age') is-invalid @enderror" id="father_age" name="father_age" value="{{ old('father_age') }}">
                        @error('father_age')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="mother_name" class="form-label">Name of Mother</label>
                        <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name') }}">
                        @error('mother_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="mother_education" class="form-label">Mother's Educational Attainment</label>
                        <input type="text" class="form-control @error('mother_education') is-invalid @enderror" id="mother_education" name="mother_education" value="{{ old('mother_education') }}">
                        @error('mother_education')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="mother_occupation" class="form-label">Mother's Occupation</label>
                        <input type="text" class="form-control @error('mother_occupation') is-invalid @enderror" id="mother_occupation" name="mother_occupation" value="{{ old('mother_occupation') }}">
                        @error('mother_occupation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="mother_age" class="form-label">Mother's Age</label>
                        <input type="number" class="form-control @error('mother_age') is-invalid @enderror" id="mother_age" name="mother_age" value="{{ old('mother_age') }}">
                        @error('mother_age')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="guardian_name" class="form-label">Guardian's Name</label>
                        <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}">
                        @error('guardian_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="guardian_relationship" class="form-label">Relationship with Guardian</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="guardian_relationship" id="parent" value="Parent" {{ old('guardian_relationship') == 'Parent' ? 'checked' : '' }}>
                                <label class="form-check-label" for="parent">Parent</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="guardian_relationship" id="spouse" value="Spouse" {{ old('guardian_relationship') == 'Spouse' ? 'checked' : '' }}>
                                <label class="form-check-label" for="spouse">Spouse</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="guardian_relationship" id="sibling" value="Sister/Brother" {{ old('guardian_relationship') == 'Sister/Brother' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sibling">Sister/Brother</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="guardian_relationship" id="relative" value="Relative" {{ old('guardian_relationship') == 'Relative' ? 'checked' : '' }}>
                                <label class="form-check-label" for="relative">Relative</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="guardian_relationship" id="friend" value="Friend" {{ old('guardian_relationship') == 'Friend' ? 'checked' : '' }}>
                                <label class="form-check-label" for="friend">Friend</label>
                            </div>
                        </div>
                        @error('guardian_relationship')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="guardian_occupation" class="form-label">Occupation of Guardian</label>
                        <input type="text" class="form-control @error('guardian_occupation') is-invalid @enderror" id="guardian_occupation" name="guardian_occupation" value="{{ old('guardian_occupation') }}">
                        @error('guardian_occupation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="guardian_contact" class="form-label">Contact Number of Guardian</label>
                        <input type="text" class="form-control @error('guardian_contact') is-invalid @enderror" id="guardian_contact" name="guardian_contact" value="{{ old('guardian_contact') }}">
                        @error('guardian_contact')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                           <div class="row mb-3">
                                 <div class="col-md-12">
                                    <label class="form-label">Parent's Marital Relationship</label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="parent_marital_status" id="living_together" value="Living together" {{ old('parent_marital_status') == 'Living together' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="living_together">Living together</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="parent_marital_status" id="temporarily_separated" value="Temporarily Separated" {{ old('parent_marital_status') == 'Temporarily Separated' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="temporarily_separated">Temporarily Separated</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="parent_marital_status" id="permanently_separated" value="Permanently Separated" {{ old('parent_marital_status') == 'Permanently Separated' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permanently_separated">Permanently Separated</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="parent_marital_status" id="father_ofw" value="Father OFW" {{ old('parent_marital_status') == 'Father OFW' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="father_ofw">Father OFW</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="parent_marital_status" id="mother_ofw" value="Mother OFW" {{ old('parent_marital_status') == 'Mother OFW' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mother_ofw">Mother OFW</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="parent_marital_status" id="deceased_parents" value="Deceased Parents" {{ old('parent_marital_status') == 'Deceased Parents' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="deceased_parents">Deceased Parents</label>
                                        </div>
                                    </div>
                                    @error('parent_marital_status')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
            
                            <!-- Number of children -->
                            <div class="mb-3">
                                <label for="number_of_children" class="form-label">Number of children in the family including yourself *</label>
                                <input type="number" class="form-control @error('number_of_children') is-invalid @enderror" name="number_of_children" id="number_of_children" value="{{ old('number_of_children') }}" required>
                                @error('number_of_children')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <!-- Birth order -->
                            <div class="mb-3">
                                <label for="birth_order" class="form-label">Birth order (ex. 1st child, 2nd child, etc.)</label>
                                <input type="text" class="form-control @error('birth_order') is-invalid @enderror" id="birth_order" name="birth_order" value="{{ old('birth_order') }}">
                                @error('birth_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <!-- Financers -->
                            <div class="mb-3">
                                <label class="form-label">Who finances your schooling: (Check all applicable) *</label><br>
                                @foreach(['Parents', 'Relatives', 'Siblings', 'Guardian', 'Scholarship Grant', 'Self-support', 'Other'] as $source)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="finances[]" value="{{ $source }}" id="finance_{{ strtolower(str_replace(' ', '_', $source)) }}" {{ (is_array(old('finances')) && in_array($source, old('finances'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="finance_{{ strtolower(str_replace(' ', '_', $source)) }}">{{ $source }}</label>
                                    </div>
                                @endforeach
                                @error('finances')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
            
                            <!-- Monthly income -->
                            <div class="mb-3">
                                <label class="form-label">Total family monthly income *</label><br>
                                @foreach([
                                    'Less than 5,000',
                                    '5,001-10,000',
                                    '10,001-15,000',
                                    '15,001-20,000',
                                    '20,001-25,000',
                                    '25,001 and above'
                                ] as $income)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="monthly_income" id="income_{{ strtolower(str_replace([' ', ',', '-'], '_', $income)) }}" value="{{ $income }}" {{ old('monthly_income') == $income ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="income_{{ strtolower(str_replace([' ', ',', '-'], '_', $income)) }}">{{ $income }}</label>
                                    </div>
                                @endforeach
                                @error('monthly_income')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
            
                            <!-- Weekly allowance -->
                            <div class="mb-3">
                                <label for="weekly_allowance" class="form-label">Your weekly allowance</label>
                                <input type="text" class="form-control @error('weekly_allowance') is-invalid @enderror" id="weekly_allowance" name="weekly_allowance" value="{{ old('weekly_allowance') }}">
                                @error('weekly_allowance')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <!-- Health Information Section -->
                            <div class="row mb-4 mt-4">
                                <div class="col-md-12">
                                    <h5 class="border-bottom pb-2">Health Information</h5>
                                </div>
                            </div>
            
                            <!-- Health - Academic -->
                            <div class="mb-3">
                                <label class="form-label">Academic health problems (Check if applicable):</label><br>
                                @foreach(['Your vision', 'Your speech', 'Your hearing', 'Your general health'] as $health)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="academic_health[]" id="health_{{ strtolower(str_replace(' ', '_', $health)) }}" value="{{ $health }}" {{ (is_array(old('academic_health')) && in_array($health, old('academic_health'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health_{{ strtolower(str_replace(' ', '_', $health)) }}">{{ $health }}</label>
                                    </div>
                                @endforeach
                                @error('academic_health')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
            
                            <div class="mb-3">
                                <label for="physical_health" class="form-label">Physical Health Concerns</label>
                                <textarea class="form-control @error('physical_health') is-invalid @enderror" id="physical_health" name="physical_health" rows="2">{{ old('physical_health') }}</textarea>
                                @error('physical_health')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <!-- Health - Psychological -->
                            <div class="mb-3">
                                <label class="form-label">Psychological consultation (Check if applicable):</label><br>
                                @foreach(['Guidance Counselor', 'Psychologist', 'Psychiatrist'] as $psy)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="psych_consultation[]" id="psych_{{ strtolower(str_replace(' ', '_', $psy)) }}" value="{{ $psy }}" {{ (is_array(old('psych_consultation')) && in_array($psy, old('psych_consultation'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="psych_{{ strtolower(str_replace(' ', '_', $psy)) }}">{{ $psy }}</label>
                                    </div>
                                @endforeach
                                @error('psych_consultation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="allergies" class="form-label">Allergies</label>
                                    <input type="text" class="form-control @error('allergies') is-invalid @enderror" id="allergies" name="allergies" value="{{ old('allergies') }}">
                                    @error('allergies')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="medications" class="form-label">Medications</label>
                                    <input type="text" class="form-control @error('medications') is-invalid @enderror" id="medications" name="medications" value="{{ old('medications') }}">
                                    @error('medications')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="mb-3">
                                <label for="emergency_contact" class="form-label">Emergency Contact (Name and Number)</label>
                                <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}">
                                @error('emergency_contact')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <!-- Interests and Hobbies Section -->
                            <div class="row mb-4 mt-4">
                                <div class="col-md-12">
                                    <h5 class="border-bottom pb-2">Interests and Hobbies</h5>
                                </div>
                            </div>
            
                            <div class="mb-3">
                                <label for="fav_subjects" class="form-label">What is/are your favorite subjects? *</label>
                                <input type="text" class="form-control @error('fav_subjects') is-invalid @enderror" id="fav_subjects" name="fav_subjects" value="{{ old('fav_subjects') }}" required>
                                @error('fav_subjects')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="mb-3">
                                <label for="least_subjects" class="form-label">What is/are the subjects you like least? *</label>
                                <input type="text" class="form-control @error('least_subjects') is-invalid @enderror" id="least_subjects" name="least_subjects" value="{{ old('least_subjects') }}" required>
                                @error('least_subjects')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="mb-3">
                                <label for="hobbies" class="form-label">What are your hobbies? (in order of preference) *</label>
                                <input type="text" class="form-control @error('hobbies') is-invalid @enderror" id="hobbies" name="hobbies" value="{{ old('hobbies') }}" required>
                                @error('hobbies')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills and Talents</label>
                                <input type="text" class="form-control @error('skills') is-invalid @enderror" id="skills" name="skills" value="{{ old('skills') }}">
                                @error('skills')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="mb-3">
                                <label for="extra_curricular" class="form-label">Extra-curricular Activities</label>
                                <input type="text" class="form-control @error('extra_curricular') is-invalid @enderror" id="extra_curricular" name="extra_curricular" value="{{ old('extra_curricular') }}">
                                @error('extra_curricular')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <!-- Intake Interview Section -->
                            <div class="row mb-4 mt-4">
                                <div class="col-md-12">
                                    <h5 class="border-bottom pb-2">Intake Interview</h5>
                                    <p class="text-muted small">Please complete the following sentences</p>
                                </div>
                            </div>
            
                            @foreach([
                                'My father' => 'father',
                                'My mother' => 'mother',
                                'My family' => 'family',
                                'My sibling/s' => 'siblings',
                                'My childhood' => 'childhood',
                                'My friends' => 'friends',
                                'My school' => 'school',
                                'My dream' => 'dream',
                                'My weakness' => 'weakness',
                                'I am afraid' => 'fear',
                                'My strength' => 'strength',
                                'In 5 years, I see myself' => 'future_vision'
                            ] as $label => $name)
                            <div class="mb-3">
                                <label for="{{ $name }}" class="form-label">{{ $label }}:</label>
                                <input type="text" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}">
                                @error($name)
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            @endforeach
            
                            <!-- Submit Button -->
                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary px-5">Submit Form</button>
                                    <button type="reset" class="btn btn-secondary ms-2">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <script>
            // Form validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all forms we want to apply custom validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
            
            // Calculate age automatically when date of birth is entered
            document.getElementById('date_of_birth').addEventListener('change', function() {
                const dob = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                
                if (!isNaN(age) && age > 0) {
                    document.getElementById('age').value = age;
                }
            });
            
            // Populate permanent address with residential address if checked
            function setupAddressCopy() {
                const checkbox = document.createElement('div');
                checkbox.className = 'form-check mt-2';
                checkbox.innerHTML = `
                    <input class="form-check-input" type="checkbox" id="same_address">
                    <label class="form-check-label" for="same_address">Same as Residential Address</label>
                `;
                
                const permanentAddressField = document.getElementById('permanent_address');
                permanentAddressField.parentNode.appendChild(checkbox);
                
                document.getElementById('same_address').addEventListener('change', function() {
                    if (this.checked) {
                        permanentAddressField.value = document.getElementById('residential_address').value;
                        permanentAddressField.setAttribute('readonly', true);
                    } else {
                        permanentAddressField.removeAttribute('readonly');
                    }
                });
            }
            
            // Call setup function when DOM is loaded
            document.addEventListener('DOMContentLoaded', setupAddressCopy);
            </script>
            @endsection