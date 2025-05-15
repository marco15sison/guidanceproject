<!-- resources/views/faculty/reports/respond.blade.php -->
@extends('layouts.faculty')

@section('title', 'Respond to Admin')

@section('page_title', 'Respond to Administration Request')

@section('custom_styles')
<style>
    .response-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }
    
    .response-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .response-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #7b1fa2;
        margin-bottom: 0;
    }
    
    .original-message {
        background-color: #f3e5f5;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        border-left: 4px solid #7b1fa2;
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
    
    .response-form {
        margin-top: 30px;
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
    
    .response-textarea {
        min-height: 150px;
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
        border-color: #7b1fa2;
        background-color: #f3e5f5;
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
    
    .admin-info-card {
        background-color: #e8eaf6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #3f51b5;
    }
    
    .referral-summary {
        margin-bottom: 30px;
    }
    
    .summary-item {
        margin-bottom: 10px;
        display: flex;
    }
    
    .summary-label {
        font-weight: 500;
        color: #666;
        width: 150px;
    }
    
    .summary-value {
        flex: 1;
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
    
    .admin-status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .admin-action {
        background-color: #f3e5f5;
        color: #7b1fa2;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="response-container">
        <div class="response-header">
            <h5 class="response-title">
                <i class="fas fa-reply me-2"></i> Respond to Administration Request
            </h5>
            <a href="{{ route('faculty.reports.referral.view', $referral->referral_id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Referral
            </a>
        </div>
        
        <div class="admin-info-card">
            <p><i class="fas fa-info-circle me-2"></i> You are responding to a message from the {{ $referral->adminDepartment ? $referral->adminDepartment->name : 'Administration' }} regarding referral <strong>{{ $referral->referral_id }}</strong> for student <strong>{{ $referral->report->student->name }}</strong>.</p>
        </div>
        
        <div class="referral-summary">
            <h6 class="mb-3">Referral Summary</h6>
            <div class="summary-item">
                <div class="summary-label">Referral ID:</div>
                <div class="summary-value">{{ $referral->referral_id }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Student:</div>
                <div class="summary-value">{{ $referral->report->student->name }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Original Report:</div>
                <div class="summary-value">{{ $referral->report->title }} (#{{ $referral->report->report_id }})</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Current Status:</div>
                <div class="summary-value"><span class="admin-status-badge admin-{{ $referral->status }}">{{ $referral->formatted_status }}</span></div>
            </div>
        </div>
        
        <div class="original-message">
            <h6 class="mb-3">Message from {{ $referral->adminDepartment ? $referral->adminDepartment->name : 'Administration' }}</h6>
            <div class="message-header">
                <div class="message-avatar">
                    {{ $latestMessage && $latestMessage->sender ? substr($latestMessage->sender->name, 0, 2) : 'AD' }}
                </div>
                <div class="message-info">
                    <div class="message-sender">{{ $latestMessage && $latestMessage->sender ? $latestMessage->sender->name : 'Administrator' }}</div>
                    <div class="message-timestamp">{{ $latestMessage ? $latestMessage->created_at->format('M d, Y \a\t h:i A') : '' }}</div>
                </div>
            </div>
            <div class="message-content">
                <p>{{ $latestMessage ? $latestMessage->content : 'Action required on this referral. Please respond with the requested information.' }}</p>
            </div>
            
            @if($latestMessage && count($latestMessage->documents) > 0)
            <div class="attachments">
                <h6 class="mt-3 mb-2">Attached Documents</h6>
                @foreach($latestMessage->documents as $document)
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
        
        <div class="response-form">
            <form action="{{ route('faculty.reports.referral.submitResponse', $referral->referral_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="responseContent" class="form-label required-field">Your Response</label>
                    <textarea class="form-control response-textarea" id="responseContent" name="response_content" placeholder="Type your response here..." required>{{ old('response_content') }}</textarea>
                    @error('response_content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Attach Supporting Documents (Optional)</label>
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
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="requestFollowup" name="request_followup">
                    <label class="form-check-label" for="requestFollowup">
                        Request follow-up information after their next meeting with the student
                    </label>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('faculty.reports.referral.view', $referral->referral_id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Response
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
        
        // Text editor with suggestions
        $('#responseContent').focus(function() {
            if ($(this).val() === '') {
                var placeholderText = "Dear Administrator,\n\nThank you for your message regarding {{ $referral->report->student->name }}. Here is the information you requested:\n\n[Your detailed response here]\n\nPlease let me know if you need any additional information or have further questions.\n\nRegards,\n{{ Auth::user()->name }}";
                
                $(this).val(placeholderText);
                
                // Position cursor at the right spot for editing
                var position = placeholderText.indexOf('[Your detailed response here]');
                this.setSelectionRange(position, position + '[Your detailed response here]'.length);
            }
        });
    });
</script>
@endsection