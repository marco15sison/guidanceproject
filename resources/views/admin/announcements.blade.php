<!-- resources/views/admin/announcements.blade.php -->
@extends('layouts.admin')

@section('title', 'Announcements')

@section('page_title')
    <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Announcement Management</h4>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Announcement Categories</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Categories will be loaded dynamically -->
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" placeholder="Search categories...">
                        <button class="btn btn-sm btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">General Announcements</h5>
                    <div>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                            <i class="fas fa-plus me-1"></i> Create Announcement
                        </button>
                        <div class="btn-group ms-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-sort me-1"></i> Sort
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Newest First</a></li>
                                <li><a class="dropdown-item" href="#">Oldest First</a></li>
                                <li><a class="dropdown-item" href="#">Most Viewed</a></li>
                                <li><a class="dropdown-item" href="#">Alphabetical</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Target Audience</th>
                                    <th>Publish Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Announcements will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <!-- Pagination will be generated dynamically -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Announcement Analytics</h5>
                </div>
                <div class="card-body">
                    <canvas id="announcementAnalyticsChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Scheduled Announcements</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Next 7 Days
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Next 7 Days</a></li>
                            <li><a class="dropdown-item" href="#">Next 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">All Scheduled</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Scheduled announcements will be loaded dynamically -->
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.announcements.scheduled') }}" class="btn btn-sm btn-outline-primary d-block">View All Scheduled</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Announcement Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (FontAwesome)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                <input type="text" class="form-control" name="icon" value="fa-bullhorn">
                            </div>
                            <small class="text-muted">Example: fa-calendar, fa-bell, fa-newspaper, etc.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Display Color</label>
                            <input type="color" class="form-control form-control-color" name="color" value="#0d6efd">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="activeCategory" name="is_active" value="1" checked>
                            <label class="form-check-label" for="activeCategory">
                                Active
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCategoryBtn">Add Category</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Announcement Modal -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="announcementForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category_id" required>
                                    <!-- Categories will be loaded dynamically -->
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="saveDraftBtn">Save as Draft</button>
                    <button type="button" class="btn btn-primary" id="publishBtn">Publish</button>
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
    // Load categories
    loadCategories();
    
    // Load scheduled announcements
    loadScheduledAnnouncements();
    
    // Load analytics
    loadAnalytics();
    
    // Initialize TinyMCE if available
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#announcementContent',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help'
        });
    }
    
    // Reinitialize TinyMCE when modal is shown
    $('#addAnnouncementModal').on('shown.bs.modal', function() {
        if (typeof tinymce !== 'undefined') {
            // Check if TinyMCE is already initialized for this textarea
            if (!tinymce.get('announcementContent')) {
                tinymce.init({
                    selector: '#announcementContent',
                    height: 300,
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help'
                });
            }
        }
    });
    
    // Add category button
    $('#saveCategoryBtn').click(function() {
        addCategory();
    });
    
    // Save draft button
    $('#saveDraftBtn').click(function() {
        saveAnnouncement('draft');
    });
    
    // Publish button
    $('#publishBtn').click(function() {
        saveAnnouncement('active');
    });
    
    // Category search functionality
    $('.card-footer .form-control').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        // Filter categories based on search term
        $('.list-group-item').each(function() {
            const categoryText = $(this).text().toLowerCase();
            if (categoryText.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // UNIFIED EVENT HANDLERS
    // Handle View (Preview) button click
    $(document).on("click", ".preview-btn", function(e) {
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
                showNotification('Failed to load announcement details', 'danger');
                console.error(xhr);
            }
        });
    });
    
    // Handle Edit button click
    $(document).on("click", ".edit-btn", function(e) {
        e.preventDefault();
        const announcementId = $(this).data('id');
        window.location.href = '/admin/announcements/' + announcementId + '/edit';
    });
    
    // Handle Delete button click
    $(document).on("click", ".delete-btn", function(e) {
        e.preventDefault();
        const announcementId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this announcement?')) {
            $.ajax({
                url: '/admin/api/announcements/' + announcementId,
                method: 'DELETE',
                success: function() {
                    // Reload announcements
                    const activeCategoryId = $('.list-group-item.active').data('category-id');
                    loadAnnouncements(activeCategoryId);
                    
                    // Update category count
                    const categoryBadge = $('.list-group-item.active .badge');
                    const count = parseInt(categoryBadge.text()) - 1;
                    categoryBadge.text(count);
                    
                    showNotification('Announcement deleted successfully', 'success');
                },
                error: function(xhr) {
                    showNotification('Failed to delete announcement', 'danger');
                    console.error(xhr);
                }
            });
        }
    });
    
    // Dropdown for scheduled announcements timeframe
    $('.dropdown-item:contains("Next 7 Days")').click(function(e) {
        e.preventDefault();
        loadScheduledAnnouncements(7);
        $('.dropdown-toggle:contains("Next")').text('Next 7 Days');
    });
    
    $('.dropdown-item:contains("Next 30 Days")').click(function(e) {
        e.preventDefault();
        loadScheduledAnnouncements(30);
        $('.dropdown-toggle:contains("Next")').text('Next 30 Days');
    });
    
    $('.dropdown-item:contains("All Scheduled")').click(function(e) {
        e.preventDefault();
        loadScheduledAnnouncements(365); // A year should cover "all"
        $('.dropdown-toggle:contains("Next")').text('All Scheduled');
    });
    
    // Sort dropdown functionality
    $('.dropdown-item:contains("Newest First")').click(function(e) {
        e.preventDefault();
        const activeCategoryId = $('.list-group-item.active').data('category-id');
        // Set sort parameters in sessionStorage for persistence
        sessionStorage.setItem('announcements_sort_by', 'publish_date');
        sessionStorage.setItem('announcements_sort_dir', 'desc');
        loadAnnouncements(activeCategoryId);
    });
    
    $('.dropdown-item:contains("Oldest First")').click(function(e) {
        e.preventDefault();
        const activeCategoryId = $('.list-group-item.active').data('category-id');
        sessionStorage.setItem('announcements_sort_by', 'publish_date');
        sessionStorage.setItem('announcements_sort_dir', 'asc');
        loadAnnouncements(activeCategoryId);
    });
    
    $('.dropdown-item:contains("Most Viewed")').click(function(e) {
        e.preventDefault();
        const activeCategoryId = $('.list-group-item.active').data('category-id');
        sessionStorage.setItem('announcements_sort_by', 'views');
        sessionStorage.setItem('announcements_sort_dir', 'desc');
        loadAnnouncements(activeCategoryId);
    });
    
    $('.dropdown-item:contains("Alphabetical")').click(function(e) {
        e.preventDefault();
        const activeCategoryId = $('.list-group-item.active').data('category-id');
        sessionStorage.setItem('announcements_sort_by', 'title');
        sessionStorage.setItem('announcements_sort_dir', 'asc');
        loadAnnouncements(activeCategoryId);
    });
});

// Load categories function
function loadCategories() {
    $.ajax({
        url: '/admin/api/announcement-categories',
        method: 'GET',
        success: function(data) {
            console.log('Categories loaded:', data);
            const categoryList = $('.list-group.list-group-flush');
            categoryList.empty();
            
            if (!data || data.length === 0) {
                categoryList.html(`
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>No categories found</span>
                    </div>
                `);
                return;
            }
            
            data.forEach(function(category, index) {
                const categoryItem = `
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ${index === 0 ? 'active' : ''}" 
                       data-category-id="${category.id}">
                        <span><i class="fas ${category.icon || 'fa-folder'} me-2" style="color: ${category.color || '#6c757d'}"></i>${category.name}</span>
                        <span class="badge bg-light text-primary rounded-pill">${category.announcements_count || 0}</span>
                    </a>
                `;
                categoryList.append(categoryItem);
            });
            
            // Set first category as active and load its announcements
            if (data.length > 0) {
                // Update the announcement list title with the first category name
                $('.col-lg-8 .card-header h5').text(data[0].name + " Announcements");
                
                // Load announcements for the first category
                loadAnnouncements(data[0].id);
                
                // Update select dropdown in the Add Announcement modal
                const categorySelect = $('select[name="category_id"]');
                if (categorySelect.length > 0) {
                    categorySelect.empty();
                    
                    data.forEach(function(category) {
                        if (category.is_active) {
                            categorySelect.append(new Option(category.name, category.id));
                        }
                    });
                }
            }
            
            // Add click handler for categories
            $('.list-group-item').click(function(e) {
                e.preventDefault();
                $('.list-group-item').removeClass('active');
                $(this).addClass('active');
                
                const categoryId = $(this).data('category-id');
                const categoryName = $(this).find('span:first').text().trim();
                
                // Update the announcement list title
                $('.col-lg-8 .card-header h5').text(categoryName + " Announcements");
                
                // Load announcements for this category
                loadAnnouncements(categoryId);
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to load categories:', error);
            console.error('Response:', xhr.responseText);
            
            const categoryList = $('.list-group.list-group-flush');
            categoryList.html(`
                <div class="list-group-item list-group-item-danger">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Failed to load categories
                    </div>
                    <small>Server error: ${error || 'Unknown error'}</small>
                </div>
            `);
        }
    });
}

// Enhanced loadAnnouncements function
function loadAnnouncements(categoryId, page = 1) {
    // Set up CSRF token if not already done
    if (!$.ajaxSettings.headers) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    
    // Get sort parameters from sessionStorage if available
    const sortBy = sessionStorage.getItem('announcements_sort_by') || 'publish_date';
    const sortDir = sessionStorage.getItem('announcements_sort_dir') || 'desc';
    
    // Show loading indicator
    const tableBody = $('.table tbody');
    tableBody.html(`
        <tr>
            <td colspan="6" class="text-center">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-2">Loading announcements...</span>
            </td>
        </tr>
    `);
    
    // Debug information
    console.log(`Loading announcements for category ID: ${categoryId}`);
    
    $.ajax({
        url: '/admin/api/announcements',
        method: 'GET',
        data: {
            category_id: categoryId,
            page: page,
            sort_by: sortBy,
            sort_dir: sortDir
        },
        success: function(response) {
            // Clear loading indicator
            tableBody.empty();
            
            // Debug response
            console.log('Announcements response:', response);
            
            // Extract announcements from response
            let announcements = [];
            let hasData = false;
            
            if (Array.isArray(response)) {
                announcements = response;
                hasData = announcements.length > 0;
            } else if (response.data && Array.isArray(response.data)) {
                announcements = response.data;
                hasData = announcements.length > 0;
            } else if (response.id) {
                // Single announcement object
                announcements = [response];
                hasData = true;
            }
            
            // If no announcements found
            if (!hasData) {
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="py-4">
                                <i class="fas fa-info-circle fa-2x text-info mb-3"></i>
                                <p class="mb-3">No announcements found for this category</p>
                                <a href="/admin/announcements/create" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create Announcement
                                </a>
                            </div>
                        </td>
                    </tr>
                `);
                
                // Clear pagination
                $('.pagination').empty();
                return;
            }
            
            // Display the announcements
            announcements.forEach(function(announcement) {
                if (!announcement) return;
                
                // Format dates
                const publishDate = formatDate(announcement.publish_date);
                const expiryDate = formatDate(announcement.expiry_date);
                
                // Create status badge
                let statusBadge = '';
                switch(announcement.status) {
                    case 'active':
                        statusBadge = '<span class="badge bg-success">Active</span>';
                        break;
                    case 'scheduled':
                        statusBadge = '<span class="badge bg-warning">Scheduled</span>';
                        break;
                    case 'expired':
                        statusBadge = '<span class="badge bg-secondary">Expired</span>';
                        break;
                    case 'draft':
                        statusBadge = '<span class="badge bg-info">Draft</span>';
                        break;
                    default:
                        statusBadge = '<span class="badge bg-secondary">Unknown</span>';
                }
                
                // Create audience badge
                const audienceBadge = `<span class="badge bg-info">${announcement.target_audience || 'All Students'}</span>`;
                
                // Create row
                const row = `
                    <tr data-announcement-id="${announcement.id}">
                        <td>${announcement.title || 'Untitled'}</td>
                        <td>${audienceBadge}</td>
                        <td>${publishDate}</td>
                        <td>${expiryDate}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-outline-primary preview-btn" data-id="${announcement.id}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary edit-btn" data-id="${announcement.id}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger delete-btn" data-id="${announcement.id}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                
                tableBody.append(row);
            });
            
            // Setup pagination if available
            if (response.current_page !== undefined && response.last_page !== undefined) {
                updatePagination(response, categoryId);
            } else {
                $('.pagination').empty();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading announcements:', error);
            console.error('Response:', xhr.responseText);
            
            tableBody.html(`
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        <div class="py-4">
                            <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                            <p>Error loading announcements: ${error || 'Unknown error'}</p>
                            <button class="btn btn-outline-primary mt-2" onclick="loadAnnouncements(${categoryId})">
                                <i class="fas fa-sync me-2"></i>Try Again
                            </button>
                        </div>
                    </td>
                </tr>
            `);
            
            // Clear pagination
            $('.pagination').empty();
        }
    });
}

// Helper function to format dates
function formatDate(dateString) {
    if (!dateString) return 'N/A';
    
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString();
    } catch(e) {
        return dateString;
    }
}

// Updated pagination function
function updatePagination(response, categoryId) {
    const pagination = $('.pagination');
    pagination.empty();
    
    // Only show pagination if we have more than one page
    if (response.last_page <= 1) {
        return;
    }
    
    // Previous page link
    const prevDisabled = response.current_page === 1 ? 'disabled' : '';
    pagination.append(`
        <li class="page-item ${prevDisabled}">
            <a class="page-link" href="#" data-page="${response.current_page - 1}">Previous</a>
        </li>
    `);
    
    // Page links
    for (let i = 1; i <= response.last_page; i++) {
        const active = i === response.current_page ? 'active' : '';
        pagination.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
    }
    
    // Next page link
    const nextDisabled = response.current_page === response.last_page ? 'disabled' : '';
    pagination.append(`
        <li class="page-item ${nextDisabled}">
            <a class="page-link" href="#" data-page="${response.current_page + 1}">Next</a>
        </li>
    `);
    
    // Add click handler for pagination
    $('.page-link').click(function(e) {
        e.preventDefault();
        
        if ($(this).parent().hasClass('disabled')) {
            return;
        }
        
        const page = $(this).data('page');
        loadAnnouncements(categoryId, page);
    });
}

// Update pagination function
function updatePagination(response) {
    const pagination = $('.pagination');
    pagination.empty();
    
    // Previous page link
    const prevDisabled = response.current_page === 1 ? 'disabled' : '';
    pagination.append(`
        <li class="page-item ${prevDisabled}">
            <a class="page-link" href="#" data-page="${response.current_page - 1}">Previous</a>
        </li>
    `);
    
    // Page links
    for (let i = 1; i <= response.last_page; i++) {
        const active = i === response.current_page ? 'active' : '';
        pagination.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
    }
    
    // Next page link
    const nextDisabled = response.current_page === response.last_page ? 'disabled' : '';
    pagination.append(`
        <li class="page-item ${nextDisabled}">
            <a class="page-link" href="#" data-page="${response.current_page + 1}">Next</a>
        </li>
    `);
    
    // Add click handler for pagination
    $('.page-link').click(function(e) {
        e.preventDefault();
        
        if ($(this).parent().hasClass('disabled')) {
            return;
        }
        
        const page = $(this).data('page');
        const activeCategoryId = $('.list-group-item.active').data('category-id');
        
        loadAnnouncements(activeCategoryId, page);
    });
}

// Load scheduled announcements function
function loadScheduledAnnouncements(days = 7) {
    $.ajax({
        url: '/admin/api/announcements/scheduled',
        method: 'GET',
        data: { days: days },
        success: function(announcements) {
            const scheduledList = $('.card:contains("Scheduled Announcements") .list-group');
            scheduledList.empty();
            
            if (announcements.length === 0) {
                scheduledList.append(`
                    <div class="list-group-item">
                        <p class="mb-0 text-muted">No scheduled announcements for the next ${days} days.</p>
                    </div>
                `);
                return;
            }
            
            announcements.forEach(function(announcement) {
                const publishDate = new Date(announcement.publish_date).toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                });
                
                scheduledList.append(`
                    <a href="#" class="list-group-item list-group-item-action" data-id="${announcement.id}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${announcement.title}</h6>
                            <small class="text-success">${publishDate}</small>
                        </div>
                        <p class="mb-1">${announcement.content.replace(/<[^>]*>/g, '').substring(0, 100)}...</p>
                        <small class="text-muted">Target: ${announcement.target_audience}</small>
                    </a>
                `);
            });
            
            // Add click handler for scheduled announcements
            $('.card:contains("Scheduled Announcements") .list-group-item').click(function(e) {
                e.preventDefault();
                const announcementId = $(this).data('id');
                
                // Redirect to edit page
                window.location.href = '/admin/announcements/' + announcementId + '/edit';
            });
        },
        error: function(xhr) {
            console.error(xhr);
        }
    });
}

// Load analytics function
function loadAnalytics() {
    $.ajax({
        url: '/admin/api/announcements/analytics',
        method: 'GET',
        success: function(data) {
            // Create chart if canvas and Chart.js are available
            if (typeof Chart !== 'undefined' && document.getElementById('announcementAnalyticsChart')) {
                const ctx = document.getElementById('announcementAnalyticsChart').getContext('2d');
                
                // Extract data for chart
                const labels = data.categories.map(cat => cat.name);
                const counts = data.categories.map(cat => cat.announcements_count);
                
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Active Announcements',
                            data: counts,
                            backgroundColor: 'rgba(13, 110, 253, 0.5)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        },
        error: function(xhr) {
            console.error(xhr);
        }
    });
}

// Category form handlers
function addCategory() {
    const formData = new FormData($('#categoryForm')[0]);
    
    // Convert form data to JSON
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    // Handle checkbox
    jsonData.is_active = $('#activeCategory').is(':checked') ? 1 : 0;
    
    $.ajax({
        url: '/admin/api/announcement-categories',
        method: 'POST',
        data: jsonData,
        success: function(category) {
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
            modal.hide();
            
            // Reset form
            $('#categoryForm')[0].reset();
            
            // Reload categories
            loadCategories();
            
            showNotification('Category added successfully', 'success');
        },
        error: function(xhr) {
            let message = 'Failed to add category';
            
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

// Announcement form handlers
function saveAnnouncement(status = 'draft') {
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
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAnnouncementModal'));
            modal.hide();
            
            // Reset form
            $('#announcementForm')[0].reset();
            
            // Clear TinyMCE if it exists
            if (typeof tinymce !== 'undefined' && tinymce.get('announcementContent')) {
                tinymce.get('announcementContent').setContent('');
            }
            
            // Reload announcements
            const activeCategoryId = $('.list-group-item.active').data('category-id');
            loadAnnouncements(activeCategoryId);
            
            // Update category count
            const categoryBadge = $('.list-group-item.active .badge');
            const count = parseInt(categoryBadge.text()) + 1;
            categoryBadge.text(count);
            
            const message = status === 'draft' ? 
                'Announcement saved as draft' : 
                'Announcement published successfully';
                
            showNotification(message, 'success');
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

// Run on page load to initialize the announcements interface
function initAnnouncementsPage() {
    console.log('Initializing announcements page...');
    
    // Load the first category (General Announcements)
    const firstCategoryId = $('.list-group-item.active').data('category-id');
    
    if (firstCategoryId) {
        console.log('Loading first category:', firstCategoryId);
        loadAnnouncements(firstCategoryId);
    } else {
        console.warn('No active category found');
        // Attempt to load all announcements as fallback
        loadAnnouncements('all');
    }
    
    // Add event handlers for category selection
    $('.list-group-item').click(function(e) {
        e.preventDefault();
        
        // Update active state
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        
        // Get category ID and load announcements
        const categoryId = $(this).data('category-id');
        const categoryName = $(this).text().trim();
        
        // Update header
        $('.col-lg-8 .card-header h5').text(categoryName);
        
        // Load announcements for this category
        loadAnnouncements(categoryId);
    });
    
    // Add event handler for "Create Announcement" button
    $('.create-announcement-btn').click(function(e) {
        window.location.href = '/admin/announcements/create';
    });
}

// Call this on document ready
$(document).ready(function() {
    initAnnouncementsPage();
});
</script>
@endsection