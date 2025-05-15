<!-- resources/views/admin/announcements/analytics.blade.php -->
@extends('layouts.admin')

@section('title', 'Announcement Analytics')

@section('page_title')
    <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Announcement Analytics</h4>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Announcement Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Active</h6>
                                        <h2 class="mb-0 mt-2" id="activeCount">{{ $totals['active'] ?? 0 }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-broadcast-tower fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Scheduled</h6>
                                        <h2 class="mb-0 mt-2" id="scheduledCount">{{ $totals['scheduled'] ?? 0 }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-clock fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Expired</h6>
                                        <h2 class="mb-0 mt-2" id="expiredCount">{{ $totals['expired'] ?? 0 }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-hourglass-end fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Drafts</h6>
                                        <h2 class="mb-0 mt-2" id="draftCount">{{ $totals['drafts'] ?? 0 }}</h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-pencil-alt fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Announcements by Category</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Announcements by Target Audience</h5>
            </div>
            <div class="card-body">
                <canvas id="audienceChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Most Viewed Announcements</h5>
                <a href="{{ route('admin.announcements') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Publish Date</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mostViewed as $announcement)
                            <tr>
                                <td>{{ $announcement->title }}</td>
                                <td><span class="badge bg-info">{{ $announcement->category->name }}</span></td>
                                <td>{{ $announcement->publish_date->format('Y-m-d') }}</td>
                                <td><span class="badge bg-success">{{ $announcement->views }}</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-outline-primary preview-btn" data-id="{{ $announcement->id }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Monthly Announcement Activity</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="300"></canvas>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Load analytics data
    loadAnalytics();
    
    // Handle preview button click
    $(document).on('click', '.preview-btn', function(e) {
        e.preventDefault();
        const announcementId = $(this).data('id');
        
        $.ajax({
            url: '/admin/api/announcements/' + announcementId,
            method: 'GET',
            success: function(announcement) {
                // Populate the preview modal
                $('#previewAnnouncementModal .modal-title').text(announcement.title);
                $('#previewAnnouncementModal .badge.bg-info').text(announcement.category.name);
                $('#previewAnnouncementModal small.text-muted').text('Posted: ' + new Date(announcement.publish_date).toLocaleDateString());
                
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
                
                // Open the modal
                const previewModal = new bootstrap.Modal(document.getElementById('previewAnnouncementModal'));
                previewModal.show();
            },
            error: function(xhr) {
                alert('Failed to load announcement details');
                console.error(xhr);
            }
        });
    });
});

// Load analytics data function
function loadAnalytics() {
    $.ajax({
        url: '/admin/api/announcements/analytics',
        method: 'GET',
        success: function(data) {
            // Update counters
            $('#activeCount').text(data.totals.active);
            $('#scheduledCount').text(data.totals.scheduled);
            $('#expiredCount').text(data.totals.expired);
            $('#draftCount').text(data.totals.drafts);
            
            // Create category chart
            createCategoryChart(data.categories);
            
            // Create audience chart
            createAudienceChart(data.by_audience);
            
            // Create monthly chart
            createMonthlyChart();
        },
        error: function(xhr) {
            console.error('Failed to load analytics data', xhr);
        }
    });
}

// Create category chart function
function createCategoryChart(categories) {
    if (typeof Chart !== 'undefined' && document.getElementById('categoryChart')) {
        const ctx = document.getElementById('categoryChart').getContext('2d');
        
        // Extract data for chart
        const labels = categories.map(cat => cat.name);
        const data = categories.map(cat => cat.announcements_count);
        const colors = [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ];
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Active Announcements',
                    data: data,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
}

// Create audience chart function
function createAudienceChart(audienceData) {
    if (typeof Chart !== 'undefined' && document.getElementById('audienceChart')) {
        const ctx = document.getElementById('audienceChart').getContext('2d');
        
        // Extract data for chart
        const labels = audienceData.map(item => item.target_audience);
        const data = audienceData.map(item => item.total);
        const colors = [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ];
        
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
}

// Create monthly chart function
function createMonthlyChart() {
    if (typeof Chart !== 'undefined' && document.getElementById('monthlyChart')) {
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        
        // Define past 6 months
        const months = [];
        const today = new Date();
        
        for (let i = 5; i >= 0; i--) {
            const month = new Date(today.getFullYear(), today.getMonth() - i, 1);
            const monthName = month.toLocaleString('default', { month: 'short' });
            months.push(monthName);
        }
        
        // Sample data - in a real app, this would come from the server
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Published',
                    data: [12, 19, 8, 15, 12, 10],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
}
</script>
@endsection