<!-- resources/views/faculty/reports/refer.blade.php -->
@extends('layouts.faculty')

@section('title', 'Refer Report to Admin')

@section('page_title', 'Refer Student Report to Administration')

@section('custom_styles')
<style>
    .referral-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }
    
    .report-summary {
        background-color: var(--light-accent);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .report-summary h6 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .summary-item {
        display: flex;
        margin-bottom: 8px;
    }
    
    .summary-label {
        font-weight: 500;
        width: 150px;
        color: #666;
    }
    
    .summary-value {
        flex: 1;
    }
    
    .form-label {
        font-weight: 500;
        color: #555;
    }
    
    .required-field::after {
        content: "*";
        color: #d32f2f;
        margin-left: 4px;
    }
    
    .referral-reason {
        height: 120px;
    }
    
    .priority-options {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }
    
    .priority-option {
        flex: 1;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .priority-option:hover {
        background-color: var(--light-accent);
    }
    
    .priority-option.selected {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .priority-option i {
        font-size: 1.5rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .document-upload {
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-top: 10px;
        transition: all 0.2s ease;
    }
    
    .document-upload:hover {
        border-color: var(--primary-color);
        background-color: var(--light-accent);
    }
    
    .document-upload i {
        font-size: 2rem;
        color: #999;
        margin-bottom: 10px;
    }
    
    .document-upload p {
        margin-bottom: 10px;
        color: #666;
    }
    
    .notification-options {
        margin-top: 20px;
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    
    .student-details {
        background-color: #f5f5f5;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid var(--primary-color);
    }
    
    .student-details h6 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .form-group {
        flex: 1;
        min-width: 200px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="referral-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">
                <i class="fas fa-share-square me-2"></i> Refer Report to Administration
            </h5>
            <a href="{{ route('faculty.reports.refer') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Reports
            </a>
        </div>
        
        <!-- Original Report Summary -->
        <div class="report-summary">
            <h6><i class="fas fa-file-alt me-1"></i> Original Report Summary</h6>
            <div class="summary-item">
                <div class="summary-label">Report ID:</div>
                <div class="summary-value">{{ $report->report_id }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Student:</div>
                <div class="summary-value">{{ $report->student->name }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Report Type:</div>
                <div class="summary-value">
                    <span class="report-type-badge type-{{ $report->type }}">{{ ucfirst($report->type) }}</span>
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Title:</div>
                <div class="summary-value">{{ $report->title }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Severity:</div>
                <div class="summary-value">
                    <span class="severity-indicator severity-{{ $report->severity }}"></span>
                    {{ ucfirst($report->severity) }}
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Status:</div>
                <div class="summary-value">
                    <span class="status-badge status-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Student Academic Details -->
        <div class="student-details">
            <h6><i class="fas fa-user-graduate me-1"></i> Student Academic Information</h6>
            <form action="{{ route('faculty.reports.submitReferral', $report->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="course" class="form-label required-field">Course/Program</label>
                        <select class="form-select" id="course" name="student_course" required>
                            <option value="">Select course</option>
                            <option value="BSIT" {{ isset($academicInfo) && $academicInfo->course == 'BSIT' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                            <option value="BSCS" {{ isset($academicInfo) && $academicInfo->course == 'BSCS' ? 'selected' : '' }}>Bachelor of Science in Computer Science</option>
                            <option value="BSIS" {{ isset($academicInfo) && $academicInfo->course == 'BSIS' ? 'selected' : '' }}>Bachelor of Science in Information Systems</option>
                            <option value="BSCE" {{ isset($academicInfo) && $academicInfo->course == 'BSCE' ? 'selected' : '' }}>Bachelor of Science in Civil Engineering</option>
                            <option value="BSEE" {{ isset($academicInfo) && $academicInfo->course == 'BSEE' ? 'selected' : '' }}>Bachelor of Science in Electrical Engineering</option>
                            <option value="BSA" {{ isset($academicInfo) && $academicInfo->course == 'BSA' ? 'selected' : '' }}>Bachelor of Science in Accountancy</option>
                            <option value="BSBA" {{ isset($academicInfo) && $academicInfo->course == 'BSBA' ? 'selected' : '' }}>Bachelor of Science in Business Administration</option>
                            <option value="BSN" {{ isset($academicInfo) && $academicInfo->course == 'BSN' ? 'selected' : '' }}>Bachelor of Science in Nursing</option>
                            <option value="BSED" {{ isset($academicInfo) && $academicInfo->course == 'BSED' ? 'selected' : '' }}>Bachelor of Science in Education</option>
                            <option value="BSHRM" {{ isset($academicInfo) && $academicInfo->course == 'BSHRM' ? 'selected' : '' }}>Bachelor of Science in Hotel and Restaurant Management</option>
                            <option value="other" {{ isset($academicInfo) && !in_array($academicInfo->course, ['BSIT', 'BSCS', 'BSIS', 'BSCE', 'BSEE', 'BSA', 'BSBA', 'BSN', 'BSED', 'BSHRM']) ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('student_course')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" id="otherCourseGroup" style="{{ isset($academicInfo) && !in_array($academicInfo->course, ['BSIT', 'BSCS', 'BSIS', 'BSCE', 'BSEE', 'BSA', 'BSBA', 'BSN', 'BSED', 'BSHRM']) ? 'display: block;' : 'display: none;' }}">
                        <label for="otherCourse" class="form-label required-field">Specify Course</label>
                        <input type="text" class="form-control" id="otherCourse" name="other_course" placeholder="Enter course name" value="{{ isset($academicInfo) && !in_array($academicInfo->course, ['BSIT', 'BSCS', 'BSIS', 'BSCE', 'BSEE', 'BSA', 'BSBA', 'BSN', 'BSED', 'BSHRM']) ? $academicInfo->course : '' }}">
                        @error('other_course')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="yearLevel" class="form-label required-field">Year Level</label>
                        <select class="form-select" id="yearLevel" name="year_level" required>
                            <option value="">Select year level</option>
                            <option value="1" {{ isset($academicInfo) && $academicInfo->year_level == '1' ? 'selected' : '' }}>First Year</option>
                            <option value="2" {{ isset($academicInfo) && $academicInfo->year_level == '2' ? 'selected' : '' }}>Second Year</option>
                            <option value="3" {{ isset($academicInfo) && $academicInfo->year_level == '3' ? 'selected' : '' }}>Third Year</option>
                            <option value="4" {{ isset($academicInfo) && $academicInfo->year_level == '4' ? 'selected' : '' }}>Fourth Year</option>
                            <option value="5" {{ isset($academicInfo) && $academicInfo->year_level == '5' ? 'selected' : '' }}>Fifth Year</option>
                            <option value="graduate" {{ isset($academicInfo) && $academicInfo->year_level == 'graduate' ? 'selected' : '' }}>Graduate Student</option>
                        </select>
                        @error('year_level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="section" class="form-label required-field">Section</label>
                        <input type="text" class="form-control" id="section" name="section" required placeholder="e.g., A, B, C or 1, 2, 3" value="{{ isset($academicInfo) ? $academicInfo->section : '' }}">
                        @error('section')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="mb-3">
                    <label for="referralType" class="form-label required-field">Referral Type</label>
                    <select class="form-select" id="referralType" name="referral_type" required>
                        <option value="">Select referral type</option>
                        <option value="escalation">Escalation (Needs higher authority)</option>
                        <option value="collaboration">Collaboration (Need joint handling)</option>
                        <option value="transfer">Transfer (Needs to be handled by admin)</option>
                        <option value="consultation">Consultation (Need guidance)</option>
                    </select>
                    @error('referral_type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label required-field">Priority Level</label>
                    <div class="priority-options">
                        <div class="priority-option" data-value="low">
                            <i class="fas fa-battery-quarter"></i>
                            <div>Low</div>
                            <small class="text-muted">Regular follow-up</small>
                            <input type="radio" name="priority" value="low" class="d-none" required>
                        </div>
                        <div class="priority-option" data-value="medium">
                            <i class="fas fa-battery-half"></i>
                            <div>Medium</div>
                            <small class="text-muted">Needs attention</small>
                            <input type="radio" name="priority" value="medium" class="d-none">
                        </div>
                        <div class="priority-option" data-value="high">
                            <i class="fas fa-battery-full"></i>
                            <div>High</div>
                            <small class="text-muted">Urgent action</small>
                            <input type="radio" name="priority" value="high" class="d-none">
                        </div>
                    </div>
                    @error('priority')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="recipient" class="form-label required-field">Recipient Admin Department</label>
                    <select class="form-select" id="recipient" name="recipient_department" required>
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->department_code }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('recipient_department')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="referralReason" class="form-label required-field">Reason for Referral</label>
                    <textarea class="form-control referral-reason" id="referralReason" name="referral_reason" placeholder="Please explain why this report needs admin attention..." required>{{ old('referral_reason') }}</textarea>
                    @error('referral_reason')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="actionsTaken" class="form-label">Actions Already Taken</label>
                    <textarea class="form-control" id="actionsTaken" name="actions_taken" placeholder="Describe any steps or interventions you've already implemented...">{{ old('actions_taken') }}</textarea>
                    @error('actions_taken')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Supporting Documents</label>
                    <div class="document-upload">
                        <i class="fas fa-file-upload"></i>
                        <p>Drag and drop files here or click to browse</p>
                        <small class="text-muted">Max. file size: 10MB (PDF, DOC, DOCX, JPG, PNG)</small>
                        <input type="file" name="supporting_documents[]" class="form-control" multiple style="opacity: 0; position: absolute;">
                    </div>
                    @error('supporting_documents.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="notification-options">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="notifyMe" name="notify_updates" checked>
                        <label class="form-check-label" for="notifyMe">
                            Notify me of updates and actions taken
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remainInvolved" name="remain_involved" checked>
                        <label class="form-check-label" for="remainInvolved">
                            I want to remain involved in this case
                        </label>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('faculty.reports.refer') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Submit Referral
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Priority selection
        $('.priority-option').click(function() {
            $('.priority-option').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
        });
        
        // File upload styling
        $('.document-upload').click(function() {
            $(this).find('input[type="file"]').click();
        });
        
        $('input[type="file"]').change(function() {
            var fileCount = $(this)[0].files.length;
            if (fileCount > 0) {
                $('.document-upload p').text(fileCount + ' file(s) selected');
            } else {
                $('.document-upload p').text('Drag and drop files here or click to browse');
            }
        });
        
        // Show/hide "Other" course field
        $('#course').change(function() {
            if ($(this).val() === 'other') {
                $('#otherCourseGroup').show();
                $('#otherCourse').prop('required', true);
            } else {
                $('#otherCourseGroup').hide();
                $('#otherCourse').prop('required', false);
            }
        });
    });
</script>
@endsection