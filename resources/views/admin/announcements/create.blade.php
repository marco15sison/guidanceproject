<!-- resources/views/admin/announcements/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Create Announcement')

@section('page_title')
    <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Create New Announcement</h4>
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
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Announcement Content</label>
                        <textarea class="form-control" rows="10" id="announcementContent" name="content"></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Target Audience</label>
                            <select class="form-select" name="target_audience" required>
                                <option value="All Students">All Students</option>
                                <option value="Undergraduate Students">Undergraduate Students</option>
                                <option value="Graduate Students">Graduate Students</option>
                                <option value="First-Year Students">First-Year Students</option>
                                <option value="Graduating Students">Graduating Students</option>
                                <option value="International Students">International Students</option>
                                <option value="On-Campus Students">On-Campus Students</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control" name="publish_date" value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="datetime-local" class="form-control" name="expiry_date" value="{{ now()->addDays(14)->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Attach Files (Optional)</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Display Options</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featuredAnnouncement" name="is_featured" value="1">
                                <label class="form-check-label" for="featuredAnnouncement">
                                    Feature on Student Dashboard
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.announcements') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="button" class="btn btn-success me-2" id="saveDraftBtn">Save as Draft</button>
                        <button type="button" class="btn btn-primary" id="publishBtn">Publish</button>
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
        saveAnnouncement('draft');
    });
    
    // Publish
    $('#publishBtn').click(function() {
        saveAnnouncement('active');
    });
    
    function saveAnnouncement(status) {
        // Get form data
        const formData = new FormData($('#announcementForm')[0]);
        
        // Add status if not draft
        if (status !== 'draft') {
            formData.append('status', 'active');
        }
        
        // Get content from TinyMCE if available
        if (typeof tinymce !== 'undefined' && tinymce.get('announcementContent')) {
            formData.set('content', tinymce.get('announcementContent').getContent());
        }
        
        $.ajax({
            url: '/admin/api/announcements',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(announcement) {
                const message = status === 'draft' ? 
                    'Announcement saved as draft' : 
                    'Announcement published successfully';
                    
                showNotification(message, 'success');
                
                // Redirect after short delay
                setTimeout(function() {
                    window.location.href = '/admin/announcements';
                }, 1500);
            },
            error: function(xhr) {
                let message = 'Failed to save announcement';
                
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