@extends('layouts.student')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="user_type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ ucfirst($user->user_type) }}" readonly>
                            </div>
                        </div>

                        <!-- Student Information Section -->
                        <hr>
                        <h5>Student Information</h5>

                        <div class="row mb-3">
                            <label for="student_id" class="col-md-4 col-form-label text-md-end">{{ __('Student ID') }}</label>

                            <div class="col-md-6">
                                <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ old('student_id', $user->student ? $user->student->student_id : '') }}" autocomplete="student_id">

                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="course" class="col-md-4 col-form-label text-md-end">{{ __('Course') }}</label>

                            <div class="col-md-6">
                                <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course', $user->student ? $user->student->course : '') }}" autocomplete="course">

                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="year_level" class="col-md-4 col-form-label text-md-end">{{ __('Year Level') }}</label>

                            <div class="col-md-6">
                                <select id="year_level" class="form-control @error('year_level') is-invalid @enderror" name="year_level">
                                    <option value="">Select Year Level</option>
                                    <option value="1" {{ old('year_level', $user->student ? $user->student->year_level : '') == '1' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2" {{ old('year_level', $user->student ? $user->student->year_level : '') == '2' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3" {{ old('year_level', $user->student ? $user->student->year_level : '') == '3' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4" {{ old('year_level', $user->student ? $user->student->year_level : '') == '4' ? 'selected' : '' }}>4th Year</option>
                                    <option value="5" {{ old('year_level', $user->student ? $user->student->year_level : '') == '5' ? 'selected' : '' }}>5th Year</option>
                                </select>

                                @error('year_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="section" class="col-md-4 col-form-label text-md-end">{{ __('Section') }}</label>

                            <div class="col-md-6">
                                <input id="section" type="text" class="form-control @error('section') is-invalid @enderror" name="section" value="{{ old('section', $user->student ? $user->student->section : '') }}" autocomplete="section">

                                @error('section')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="academic_year" class="col-md-4 col-form-label text-md-end">{{ __('Academic Year') }}</label>

                            <div class="col-md-6">
                                <input id="academic_year" type="text" class="form-control @error('academic_year') is-invalid @enderror" name="academic_year" value="{{ old('academic_year', $user->student ? $user->student->academic_year : '') }}" placeholder="e.g. 2024-2025" autocomplete="academic_year">

                                @error('academic_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="semester" class="col-md-4 col-form-label text-md-end">{{ __('Semester') }}</label>

                            <div class="col-md-6">
                                <select id="semester" class="form-control @error('semester') is-invalid @enderror" name="semester">
                                    <option value="">Select Semester</option>
                                    <option value="1" {{ old('semester', $user->student ? $user->student->semester : '') == '1' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2" {{ old('semester', $user->student ? $user->student->semester : '') == '2' ? 'selected' : '' }}>2nd Semester</option>
                                    <option value="summer" {{ old('semester', $user->student ? $user->student->semester : '') == 'summer' ? 'selected' : '' }}>Summer</option>
                                </select>

                                @error('semester')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <hr>
                        <h5>Change Password</h5>

                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password">

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new_password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password">

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>

                            <div class="col-md-6">
                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection