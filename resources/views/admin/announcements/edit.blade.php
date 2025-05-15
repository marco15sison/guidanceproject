<!-- resources/views/admin/announcements/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Edit Announcement')

@section('page_title')
    <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Edit Announcement</h4>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Announcement Details</h5>
            </div>
            <div class="card-body">
                <form id="announcementForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="announcementId" value="{{ $id }}">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $announcement->title }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $announcement->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Announcement Content</label>
                        <textarea class="form-control" rows="10" id="announcementContent" name="content">{{ $announcement->content }}</textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Target Audience</label>
                            <select class="form-select" name="target_audience" required>
                                <option value="All Students" {{ $announcement->target_audience == 'All Students' ? 'selected' : '' }}>All Students</option>
                                <option value="Undergraduate Students" {{ $announcement->target_audience == 'Undergraduate Students' ? 'selected' : '' }}>Undergraduate Students</option>
                                <option value="Graduate Students" {{ $announcement->target_audience == 'Graduate Students' ? 'selected' : '' }}>Graduate Students</option>
                                <option value="First-Year Students" {{ $announcement->target_audience == 'First-Year Students' ? 'selected' : '' }}>First-Year Students</option>
                                <option value="Graduating Students" {{ $announcement->target_audience == 'Graduating Students' ? 'selected' : '' }}>Graduating Students</option>
                                <option value="International Students" {{ $announcement->target_audience == 'International Students' ? 'selected' : '' }}>International Students</option>
                                <option value="On-Campus Students" {{ $announcement->target_audience == 'On-Campus Students' ? 'selected' : '' }}>On-Campus Students</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft" {{ $announcement->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="scheduled" {{ $announcement->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="active" {{ $announcement->status == 'active' ? 'selected' : '' }}>Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control" name="publish_date" value="{{ \Carbon\Carbon::parse($announcement->publish_date)->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="datetime-local" class="form-control" name="expiry_date" value="{{ \Carbon\Carbon::parse($announcement->expiry_date)->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Attach Files (Optional)</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                            <div id="existingAttachments" class="mt-2">
                                @if($announcement->attachments->count() > 0)
                                    <h6>Current Attachments:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                    @foreach($announcement->attachments as $attachment)
                                        <div class="attachment-item p-2 border rounded d-flex align-items-center">
                                            @php
                                                $iconClass = 'fa-file';
                                                if (strpos($attachment->file_type, 'pdf') !== false) {
                                                    $iconClass = 'fa-file-pdf text-danger';
                                                } elseif (strpos($attachment->file_type, 'image') !== false) {
                                                    $iconClass = 'fa-file-image text-primary';
                                                } elseif (strpos($attachment->file_type, 'word') !== false) {
                                                    $iconClass = 'fa-file-word text-primary';
                                                } elseif (strpos($attachment->file_type, 'excel') !== false || strpos($attachment->file_type, 'spreadsheet') !== false) {
                                                    $iconClass = 'fa-file-excel text-success';
                                                }
                                            @endphp
                                            <i class="fas {{ $iconClass }} me-2"></i>
                                            <span class="me-2">{{ $attachment->original_filename }}</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-attachment" data-id="{{ $attachment->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Display Options</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featuredAnnouncement" name="is_featured" value="1" {{ $announcement->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="featuredAnnouncement">
                                    Feature on Student Dashboard
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.announcements') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="button" class="btn btn-success me-2" id="saveDraftBtn">Save as Draft</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container for Notifications -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Announcement System</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Get announcement ID
    const announcementId = $('#announcementId').val();
    
    // Initialize TinyMCE if available
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#announcementContent',
            height: 400,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    }
    
    // Save as Draft
    $('#saveDraftBtn').click(function() {
        updateAnnouncement('draft');
    });
    
    // Update announcement
    $('#updateBtn').click(function() {
        updateAnnouncement();
    });
    
    // Add event handler for removing attachments
    $('.remove-attachment').click(function() {
        const attachmentId = $(this).data('id');
        removeAttachment(attachmentId);
    });
    
    function updateAnnouncement(status = null) {
        // Get form data
        const formData = new FormData($('#announcementForm')[0]);
        
        // Use method spoofing for PUT request
        formData.append('_method', 'PUT');
        
        // Add status if specified
        if (status) {
            formData.set('status', status);
        }
        
        // Get content from TinyMCE if available
        if (typeof tinymce !== 'undefined' && tinymce.get('announcementContent')) {
            formData.set('content', tinymce.get('announcementContent').getContent());
        }
        
        $.ajax({
            url: '/admin/api/announcements/' + announcementId,
            method: 'POST', // Will be converted to PUT by Laravel
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                showNotification('Announcement updated successfully', 'success');
                
                // Redirect after short delay
                setTimeout(function() {
                    window.location.href = '/admin/announcements';
                }, 1500);
            },
            error: function(xhr) {
                let message = 'Failed to update announcement';
                
                // Extract validation errors if available
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    const firstError = Object.values(errors)[0][0];
                    message = firstError;
                }
                
                showNotification(message, 'danger');
                console.error(xhr);
            }
        });
    }
    
    // Remove attachment
    function removeAttachment(attachmentId) {
        if (confirm('Are you sure you want to remove this attachment?')) {
            $.ajax({
                url: '/admin/api/announcement-attachments/' + attachmentId,
                method: 'DELETE',
                success: function() {
                    // Remove attachment from UI
                    $(`.remove-attachment[data-id="${attachmentId}"]`).closest('.attachment-item').remove();
                    showNotification('Attachment removed successfully', 'success');
                },
                error: function(xhr) {
                    showNotification('Failed to remove attachment', 'danger');
                    console.error(xhr);
                }
            });
        }
    }
    
    // Function to show notifications
    function showNotification(message, type) {
        $('#notificationToast .toast-body').text(message);
        
        // Remove all background classes first
        $('#notificationToast').removeClass('bg-success bg-info bg-warning bg-danger');
        
        // Add appropriate class based on type
        switch(type) {
            case 'success':
                $('#notificationToast').addClass('bg-success text-white');
                break;
            case 'info':
                $('#notificationToast').addClass('bg-info text-white');
                break;
            case 'warning':
                $('#notificationToast').addClass('bg-warning text-dark');
                break;
            case 'danger':
                $('#notificationToast').addClass('bg-danger text-white');
                break;
            default:
                $('#notificationToast').addClass('bg-info text-white');
        }

        // Show toast
        const toastEl = document.getElementById('notificationToast');
        const toast = new bootstrap.Toast(toastEl, {
            delay: 3000
        });
        toast.show();
    }
});
</script>
@endsection