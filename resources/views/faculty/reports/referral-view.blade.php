<!-- resources/views/faculty/reports/referral-view.blade.php -->
@extends('layouts.faculty')

@section('title', 'Referral Details')

@section('page_title', 'Referral Details')

@section('custom_styles')
<style>
    .referral-detail-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }
    
    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .detail-title {
        display: flex;
        align-items: center;
    }
    
    .detail-title h5 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #7b1fa2;
        margin-bottom: 0;
        margin-right: 10px;
    }
    
    .status-label {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .referral-info-panel {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 15px;
    }
    
    .info-label {
        font-weight: 500;
        color: #666;
        width: 200px;
    }
    
    .info-value {
        flex: 1;
    }
    
    .timeline-container {
        position: relative;
        margin: 40px 0;
    }
    
    .timeline-item {
        display: flex;
        margin-bottom: 25px;
        position: relative;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        top: 40px;
        left: 20px;
        width: 2px;
        height: calc(100% - 15px);
        background-color: #e1bee7;
    }
    
    .timeline-item:last-child::after {
        display: none;
    }
    
    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f3e5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7b1fa2;
        margin-right: 15px;
        z-index: 2;
    }
    
    .timeline-content {
        flex: 1;
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }
    
    .timeline-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .timeline-title {
        font-weight: 600;
        color: #7b1fa2;
    }
    
    .timeline-date {
        color: #999;
        font-size: 0.9rem;
    }
    
    .timeline-body {
        color: #666;
    }
    
    .attachments {
        margin-top: 20px;
    }
    
    .attachment-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }
    
    .attachment-item:hover {
        background-color: #f5f5f5;
    }
    
    .attachment-icon {
        margin-right: 10px;
        color: #7b1fa2;
    }
    
    .attachment-name {
        flex: 1;
    }
    
    .attachment-size {
        color: #999;
        font-size: 0.8rem;
        margin-right: 10px;
    }
    
    .message-box {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
    }
    
    .message-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e1bee7;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-weight: 600;
        color: #7b1fa2;
    }
    
    .message-info {
        flex: 1;
    }
    
    .message-sender {
        font-weight: 600;
    }
    
    .message-timestamp {
        font-size: 0.8rem;
        color: #999;
    }
    
    .message-content {
        color: #555;
    }
    
    .admin-note {
        background-color: #fff8e1;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-top: 20px;
        border-radius: 4px;
    }
    
    .admin-note-header {
        font-weight: 600;
        color: #ff8f00;
        margin-bottom: 10px;
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    
    .accordion {
        margin-top: 25px;
    }
    
    .accordion-item {
        margin-bottom: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .accordion-header {
        background-color: #f9f9f9;
        padding: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .accordion-title {
        font-weight: 500;
        color: #555;
    }
    
    .accordion-icon {
        transition: transform 0.3s ease;
    }
    
    .accordion-content {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
    }
    
    .accordion-content.active {
        padding: 15px;
        max-height: 1000px;
    }
    
    .referral-type-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .type-escalation {
        background-color: #ffecb3;
        color: #ff8f00;
    }
    
    .type-collaboration {
        background-color: #bbdefb;
        color: #1565c0;
    }
    
    .type-transfer {
        background-color: #c8e6c9;
        color: #2e7d32;
    }
    
    .type-consultation {
        background-color: #e1bee7;
        color: #7b1fa2;
    }
    
    .admin-status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .admin-pending {
        background-color: #fff8e1;
        color: #f57c00;
    }
    
    .admin-reviewing {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    
    .admin-accepted {
        background-color: #e8f5e9;
        color: #388e3c;
    }
    
    .admin-declined {
        background-color: #ffebee;
        color: #d32f2f;
    }
    
    .admin-action {
        background-color: #f3e5f5;
        color: #7b1fa2;
    }
    
    .priority-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .priority-low {
        background-color: #4caf50;
    }
    
    .priority-medium {
        background-color: #ff9800;
    }
    
    .priority-high {
        background-color: #f44336;
    }
    
    .faculty-message {
        background-color: #f5f5f5;
    }
    
    .admin-message {
        background-color: #f3e5f5;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="referral-detail-container">
        <div class="detail-header">
            <div class="detail-title">
                <h5><i class="fas fa-share-square me-2"></i> {{ $referral->referral_id }}</h5>
                <span class="admin-status-badge admin-{{ $referral->status }}">{{ $referral->formatted_status }}</span>
            </div>
            <div>
                <a href="{{ route('faculty.reports.referrals') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Referrals
                </a>
                <a href="{{ route('faculty.reports.show', $referral->report_id) }}" class="btn btn-outline-primary btn-sm ms-2">
                    <i class="fas fa-file-alt me-1"></i> View Original Report
                </a>
            </div>
        </div>
        
        <div class="referral-info-panel">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label">Student Name:</div>
                        <div class="info-value">{{ $referral->report->student->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Student ID:</div>
                        <div class="info-value">{{ $referral->report->student->student_id_number }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Course/Program:</div>
                        <div class="info-value">{{ $referral->report->student->academicInfo ? $referral->report->student->academicInfo->formatted_course : 'Not specified' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Year & Section:</div>
                        <div class="info-value">{{ $referral->report->student->academicInfo ? $referral->report->student->academicInfo->formatted_year_level . ' - Section ' . $referral->report->student->academicInfo->section : 'Not specified' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label">Original Report ID:</div>
                        <div class="info-value">#{{ $referral->report->report_id }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Report Issue:</div>
                        <div class="info-value">{{ $referral->report->title }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Referral Type:</div>
                        <div class="info-value">
                            <span class="referral-type-badge type-{{ $referral->referral_type }}">{{ ucfirst($referral->referral_type) }}</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Severity:</div>
                        <div class="info-value">
                            <span class="severity-indicator severity-{{ $referral->report->severity }}"></span>
                            {{ ucfirst($referral->report->severity) }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label">Priority:</div>
                        <div class="info-value">
                            <span class="priority-indicator priority-{{ $referral->priority }}"></span>
                            {{ ucfirst($referral->priority) }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Referred To:</div>
                        <div class="info-value">{{ $referral->adminDepartment ? $referral->adminDepartment->name : 'Unknown Department' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-label">Date Submitted:</div>
                        <div class="info-value">{{ $referral->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Current Status:</div>
                        <div class="info-value">
                            <span class="admin-status-badge admin-{{ $referral->status }}">{{ $referral->formatted_status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="accordion">
            <div class="accordion-item">
                <div class="accordion-header">
                    <div class="accordion-title">Referral Details</div>
                    <div class="accordion-icon">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div class="accordion-content active">
                    <h6 class="mb-3">Reason for Referral</h6>
                    <p>{{ $referral->reason }}</p>
                    
                    @if($referral->actions_taken)
                    <h6 class="mt-4 mb-3">Actions Already Taken</h6>
                    <p>{{ $referral->actions_taken }}</p>
                    @endif
                </div>
            </div>
            
            @if(count($referral->documents) > 0)
            <div class="accordion-item">
                <div class="accordion-header">
                    <div class="accordion-title">Supporting Documents</div>
                    <div class="accordion-icon">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div class="accordion-content">
                    <div class="attachments">
                        @foreach($referral->documents as $document)
                        <div class="attachment-item">
                            <div class="attachment-icon">
                                <i class="{{ $document->file_icon_class }}"></i>
                            </div>
                            <div class="attachment-name">
                                {{ $document->file_name }}
                            </div>
                            <div class="attachment-size">
                                {{ $document->formatted_file_size }}
                            </div>
                            <a href="{{ $document->download_url }}" class="btn btn-sm btn-outline-secondary" download>
                                <i class="fas fa-download"></i>
                            </a>
                            
                            @if($referral->status === 'pending')
                            <form action="{{ route('faculty.reports.document.remove', $document->id) }}" method="POST" class="ms-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this document?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="timeline-container">
            <h6 class="mb-4">Referral Timeline</h6>
            
            <!-- Display statuses -->
            @foreach($referral->statuses as $status)
            <div class="timeline-item">
                <div class="timeline-icon">
                    @if($status->status === 'pending')
                        <i class="fas fa-clock"></i>
                    @elseif($status->status === 'reviewing')
                        <i class="fas fa-search"></i>
                    @elseif($status->status === 'action_required')
                        <i class="fas fa-exclamation-triangle"></i>
                    @elseif($status->status === 'accepted')
                        <i class="fas fa-check-circle"></i>
                    @elseif($status->status === 'declined')
                        <i class="fas fa-times-circle"></i>
                    @elseif($status->status === 'resolved')
                        <i class="fas fa-check-double"></i>
                    @elseif($status->status === 'withdrawn')
                        <i class="fas fa-undo"></i>
                    @else
                        <i class="fas fa-info-circle"></i>
                    @endif
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <div class="timeline-title">Status Updated to {{ $status->formatted_status }}</div>
                        <div class="timeline-date">{{ $status->created_at->format('M d, Y • h:i A') }}</div>
                    </div>
                    <div class="timeline-body">
                        <p>{{ $status->notes }}</p>
                        <p class="text-muted mb-0">
                            <small>
                                @if($status->user_type === 'faculty')
                                    By You
                                @elseif($status->user_type === 'admin')
                                    By {{ $status->updatedBy ? $status->updatedBy->name . ' (Admin)' : 'Admin' }}
                                @else
                                    System Update
                                @endif
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Display messages -->
            @foreach($referral->messages as $message)
            <div class="timeline-item">
                <div class="timeline-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="timeline-content {{ $message->sender_type === 'faculty' ? 'faculty-message' : 'admin-message' }}">
                    <div class="timeline-header">
                        <div class="timeline-title">
                            Message from {{ $message->sender_type === 'faculty' ? 'You' : $message->formatted_sender }}
                        </div>
                        <div class="timeline-date">{{ $message->created_at->format('M d, Y • h:i A') }}</div>
                    </div>
                    <div class="timeline-body">
                        <p>{{ $message->content }}</p>
                        
                        @if($message->request_followup)
                        <div class="admin-note mt-2">
                            <p class="mb-0"><i class="fas fa-bell me-1"></i> Follow-up requested after the next meeting/action.</p>
                        </div>
                        @endif
                        
                        @if(count($message->documents) > 0)
                        <div class="attachments">
                            <h6 class="mt-3 mb-2">Attached Documents</h6>
                            @foreach($message->documents as $document)
                            <div class="attachment-item">
                                <div class="attachment-icon">
                                    <i class="{{ $document->file_icon_class }}"></i>
                                </div>
                                <div class="attachment-name">
                                    {{ $document->file_name }}
                                </div>
                                <div class="attachment-size">
                                    {{ $document->formatted_file_size }}
                                </div>
                                <a href="{{ $document->download_url }}" class="btn btn-sm btn-outline-secondary" download>
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="action-buttons">
            <a href="{{ route('faculty.reports.referrals') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Referrals
            </a>
            <div>
                <a href="{{ route('faculty.reports.show', $referral->report_id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-file-alt me-1"></i> View Original Report
                </a>
                
                @if($referral->status === 'pending')
                <a href="{{ route('faculty.reports.referral.edit', $referral->referral_id) }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-pencil-alt me-1"></i> Edit Referral
                </a>
                @endif
                
                @if($referral->status === 'action_required')
                <a href="{{ route('faculty.reports.referral.respond', $referral->referral_id) }}" class="btn btn-primary ms-2">
                    <i class="fas fa-reply me-1"></i> Respond
                </a>
                @endif
                
                @if(in_array($referral->status, ['pending', 'reviewing']))
                <button type="button" class="btn btn-outline-danger ms-2" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                    <i class="fas fa-times-circle me-1"></i> Withdraw Referral
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Withdraw Referral Modal -->
@if(in_array($referral->status, ['pending', 'reviewing']))
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Referral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('faculty.reports.referral.withdraw', $referral->referral_id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to withdraw this referral? This action cannot be undone.</p>
                    <div class="mb-3">
                        <label for="withdrawalReason" class="form-label">Please provide a reason for withdrawing:</label>
                        <textarea class="form-control" id="withdrawalReason" name="withdrawal_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Withdrawal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Accordion functionality
        $('.accordion-header').click(function() {
            var content = $(this).next('.accordion-content');
            var icon = $(this).find('.accordion-icon i');
            
            content.toggleClass('active');
            
            if (content.hasClass('active')) {
                icon.css('transform', 'rotate(180deg)');
            } else {
                icon.css('transform', 'rotate(0deg)');
            }
        });
    });
</script>
@endsection