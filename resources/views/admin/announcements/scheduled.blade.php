<!-- resources/views/admin/announcements/scheduled.blade.php -->
@extends('layouts.admin')

@section('title', 'Scheduled Announcements')

@section('page_title')
    <h4 class="mb-0"><i class="fas fa-clock me-2"></i>Scheduled Announcements</h4>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Upcoming Announcements</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ $days == 7 ? 'Next 7 Days' : ($days == 30 ? 'Next 30 Days' : 'All Scheduled') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.announcements.scheduled', ['days' => 7]) }}">Next 7 Days</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.announcements.scheduled', ['days' => 30]) }}">Next 30 Days</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.announcements.scheduled', ['days' => 365]) }}">All Scheduled</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                @if(count($scheduled) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Target Audience</th>
                                <th>Publish Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scheduled as $announcement)
                            <tr>
                                <td>{{ $announcement->title }}</td>
                                <td><span class="badge bg-info">{{ $announcement->category->name }}</span></td>
                                <td>{{ $announcement->target_audience }}</td>
                                <td>
                                    @php
                                        $publishDate = new DateTime($announcement->publish_date);
                                        $now = new DateTime();
                                        $interval = $now->diff($publishDate);
                                        $daysRemaining = $interval->days;
                                        $hoursRemaining = $interval->h;
                                    @endphp
                                    <div>{{ $publishDate->format('M d, Y - h:i A') }}</div>
                                    <small class="text-muted">
                                        @if($daysRemaining > 0)
                                            In {{ $daysRemaining }} day(s)
                                        @else
                                            In {{ $hoursRemaining }} hour(s)
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-outline-primary preview-btn" data-id="{{ $announcement->id }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-success publish-now-btn" data-id="{{ $announcement->id }}">
                                            <i class="fas fa-rocket"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No scheduled announcements found for the selected time period.
                </div>
                @endif
            </div>
            <div class="card-footer bg-white py-3">
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Create New Announcement
                </a>
                <a href="{{ route('admin.announcements') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Announcements
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Publish Timeline</h5>
            </div>
            <div class="card-body">
                @if(count($scheduled) > 0)
                <div class="position-relative">
                    <div class="timeline-horizontal">
                        @php
                            $currentDate = new DateTime();
                            $endDate = (clone $currentDate)->modify('+' . $days . ' days');
                            $dateFormat = 'M d';
                        @endphp
                        
                        <!-- Timeline Header with dates -->
                        <div class="timeline-dates d-flex justify-content-between mb-3">
                            @php
                                // Create date range for timeline
                                $interval = new DateInterval('P1D');
                                $dateRange = new DatePeriod($currentDate, $interval, $endDate);
                                $dateLabels = [];
                                
                                // Show up to 7 date labels
                                $labelCount = min(7, $days);
                                $labelInterval = max(1, floor($days / $labelCount));
                                $dayCounter = 0;
                            @endphp
                            
                            @foreach($dateRange as $date)
                                @if($dayCounter % $labelInterval == 0 || $dayCounter == 0)
                                    <div class="timeline-date-label">
                                        {{ $date->format($dateFormat) }}
                                    </div>
                                @endif
                                @php $dayCounter++; @endphp
                            @endforeach
                        </div>
                        
                        <!-- Timeline Body with events -->
                        <div class="timeline-track position-relative mb-4">
                            <!-- Timeline track line -->
                            <div class="timeline-line"></div>
                            
                            <!-- Timeline events -->
                            @foreach($scheduled as $announcement)
                                @php
                                    $publishDate = new DateTime($announcement->publish_date);
                                    $daysDiff = $currentDate->diff($publishDate)->days;
                                    $position = min(100, ($daysDiff / $days) * 100);
                                    $bgColor = 'bg-primary';
                                    
                                    if($position < 10) {
                                        $bgColor = 'bg-danger';
                                    } elseif($position < 25) {
                                        $bgColor = 'bg-warning';
                                    }
                                @endphp
                                
                                <div class="timeline-event" style="left: {{ $position }}%;" 
                                     data-bs-toggle="tooltip" data-bs-placement="top"
                                     title="{{ $announcement->title }} - {{ $publishDate->format('M d, Y h:i A') }}">
                                    <div class="timeline-event-dot {{ $bgColor }}"></div>
                                </div>
                            @endforeach
                            
                            <!-- Today marker -->
                            <div class="timeline-today-marker">
                                <div class="timeline-today-dot bg-success"></div>
                                <small class="text-success">Today</small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No scheduled announcements to display on the timeline.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Preview Announcement Modal -->
<div class="modal fade" id="previewAnnouncementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Preview Announcement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge bg-info"></span>
                    <small class="text-muted"></small>
                </div>
                <div class="announcement-content mb-4">
                    <!-- Announcement content will be loaded here -->
                </div>
                <div class="mt-3">
                    <!-- Attachments will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="modalPublishNowBtn">Publish Now</button>
                <a href="#" class="btn btn-primary" id="modalEditBtn">Edit</a>
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

@section('styles')
<style>
    .timeline-horizontal {
        position: relative;
        width: 100%;
        padding: 20px 0;
    }
    
    .timeline-dates {
        position: relative;
        width: 100%;
    }
    
    .timeline-track {
        height: 60px;
    }
    
    .timeline-line {
        position: absolute;
        height: 2px;
        width: 100%;
        background-color: #dee2e6;
        top: 15px;
    }
    
    .timeline-event {
        position: absolute;
        top: 0;
        transform: translateX(-50%);
    }
    
    .timeline-event-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        position: relative;
        top: 10px;
        cursor: pointer;
    }
    
    .timeline-today-marker {
        position: absolute;
        left: 0;
        top: 0;
        transform: translateX(-50%);
    }
    
    .timeline-today-dot {
    .timeline-today-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        position: relative;
        top: 9px;
    }
    
    .timeline-date-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Current announcement ID for modal
    let currentAnnouncementId = null;
    
    // Handle preview button click
    $(document).on('click', '.preview-btn', function(e) {
        e.preventDefault();
        const announcementId = $(this).data('id');
        currentAnnouncementId = announcementId;
        
        $.ajax({
            url: '/admin/api/announcements/' + announcementId,
            method: 'GET',
            success: function(announcement) {
                // Populate the preview modal
                $('#previewAnnouncementModal .modal-title').text(announcement.title);
                $('#previewAnnouncementModal .badge.bg-info').text(announcement.category.name);
                $('#previewAnnouncementModal small.text-muted').text('Scheduled for: ' + new Date(announcement.publish_date).toLocaleString());
                
                // Set the content
                $('.announcement-content').html(announcement.content);
                
                // Add attachments if any
                const attachmentsContainer = $('#previewAnnouncementModal .mt-3');
                
                if (announcement.attachments && announcement.attachments.length > 0) {
                    let attachmentsHTML = '<strong>Attachments:</strong><div class="d-flex flex-wrap gap-2 mt-2">';
                    
                    announcement.attachments.forEach(function(attachment) {
                        // Determine icon based on file type
                        let iconClass = 'fa-file';
                        if (attachment.file_type.includes('pdf')) {
                            iconClass = 'fa-file-pdf text-danger';
                        } else if (attachment.file_type.includes('image')) {
                            iconClass = 'fa-file-image text-primary';
                        } else if (attachment.file_type.includes('word')) {
                            iconClass = 'fa-file-word text-primary';
                        } else if (attachment.file_type.includes('excel') || attachment.file_type.includes('spreadsheet')) {
                            iconClass = 'fa-file-excel text-success';
                        }
                        
                        attachmentsHTML += `
                            <a href="/storage/${attachment.filename}" class="text-decoration-none" target="_blank">
                                <div class="d-flex align-items-center p-2 border rounded">
                                    <i class="fas ${iconClass} me-2 fa-lg"></i>
                                    <span>${attachment.original_filename}</span>
                                </div>
                            </a>
                        `;
                    });
                    
                    attachmentsHTML += '</div>';
                    attachmentsContainer.html(attachmentsHTML);
                } else {
                    attachmentsContainer.html('');
                }
                
                // Set edit button link
                $('#modalEditBtn').attr('href', '/admin/announcements/' + announcementId + '/edit');
                
                // Open the modal
                const previewModal = new bootstrap.Modal(document.getElementById('previewAnnouncementModal'));
                previewModal.show();
            },
            error: function(xhr) {
                showNotification('Failed to load announcement details', 'danger');
                console.error(xhr);
            }
        });
    });
    
    // Handle publish now button click (in table)
    $(document).on('click', '.publish-now-btn', function(e) {
        e.preventDefault();
        const announcementId = $(this).data('id');
        
        if (confirm('Are you sure you want to publish this announcement now?')) {
            publishAnnouncement(announcementId);
        }
    });
    
    // Handle publish now button click (in modal)
    $('#modalPublishNowBtn').click(function() {
        if (currentAnnouncementId && confirm('Are you sure you want to publish this announcement now?')) {
            publishAnnouncement(currentAnnouncementId);
        }
    });
    
    // Function to publish an announcement immediately
    function publishAnnouncement(id) {
        $.ajax({
            url: '/admin/api/announcements/' + id,
            method: 'PUT',
            data: {
                status: 'active',
                publish_date: new Date().toISOString()
            },
            success: function() {
                showNotification('Announcement published successfully', 'success');
                
                // Close modal if open
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('previewAnnouncementModal'));
                if (modalInstance) {
                    modalInstance.hide();
                }
                
                // Reload page after short delay
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr) {
                let message = 'Failed to publish announcement';
                
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