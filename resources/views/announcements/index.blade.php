@extends('layouts.student')

@section('title', 'Announcements')

@section('styles')
<style>
    .category-pill {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .announcement-card {
        transition: all 0.3s ease;
        border-left: 4px solid #dee2e6;
    }
    
    .announcement-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    
    .announcement-card.featured {
        border-left: 4px solid #ffc107;
    }
    
    .announcement-meta {
        font-size: 0.85rem;
    }
    
    .badge-custom {
        padding: 5px 10px;
        font-weight: 500;
        border-radius: 30px;
    }
    
    .truncate-content {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    
    .search-container {
        position: relative;
    }
    
    .search-container .search-icon {
        position: absolute;
        left: 15px;
        top: 10px;
        color: #adb5bd;
    }
    
    .search-container input {
        padding-left: 40px;
        border-radius: 30px;
    }
    
    .no-announcements {
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .skeleton-loader {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 4px;
        height: 15px;
        margin-bottom: 10px;
    }
    
    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="h3 mb-0">Announcements</h1>
            <p class="text-muted">Stay updated with the latest information and announcements</p>
        </div>
        <div class="col-lg-4">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchAnnouncements" class="form-control" placeholder="Search announcements...">
            </div>
        </div>
    </div>
    
    <!-- Categories filter pills -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap" id="categoryContainer">
                <div class="skeleton-loader w-100 d-lg-none"></div>
                <div class="skeleton-loader w-25 d-none d-lg-block"></div>
                <div class="skeleton-loader w-25 d-none d-lg-block"></div>
                <div class="skeleton-loader w-25 d-none d-lg-block"></div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Announcements list -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" id="announcementsTitle">All Announcements</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sort me-1"></i> Sort
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item sort-option" href="#" data-sort="newest">Newest First</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="oldest">Oldest First</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="alphabetical">Alphabetical</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" id="announcementsContainer">
                    <!-- Skeleton loaders while loading -->
                    <div class="skeleton-announcement">
                        <div class="skeleton-loader w-50 mb-2"></div>
                        <div class="skeleton-loader w-25 mb-3"></div>
                        <div class="skeleton-loader w-100"></div>
                        <div class="skeleton-loader w-100"></div>
                        <div class="skeleton-loader w-75"></div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="skeleton-loader w-25"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="skeleton-announcement">
                        <div class="skeleton-loader w-50 mb-2"></div>
                        <div class="skeleton-loader w-25 mb-3"></div>
                        <div class="skeleton-loader w-100"></div>
                        <div class="skeleton-loader w-100"></div>
                        <div class="skeleton-loader w-75"></div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="skeleton-loader w-25"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 d-flex justify-content-center">
                    <nav aria-label="Announcements pagination">
                        <ul class="pagination pagination-sm mb-0" id="announcementsPagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Sidebar with featured announcements -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Featured</h5>
                </div>
                <div class="card-body p-0" id="featuredAnnouncementsContainer">
                    <!-- Skeleton loaders for featured announcements -->
                    <div class="p-3 border-bottom">
                        <div class="skeleton-loader w-75 mb-2"></div>
                        <div class="skeleton-loader w-50 mb-2"></div>
                        <div class="skeleton-loader w-100"></div>
                    </div>
                    <div class="p-3 border-bottom">
                        <div class="skeleton-loader w-75 mb-2"></div>
                        <div class="skeleton-loader w-50 mb-2"></div>
                        <div class="skeleton-loader w-100"></div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Filter by Audience</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush" id="audienceFiltersContainer">
                        <!-- Skeleton loaders for audience filters -->
                        <div class="skeleton-loader w-100 mb-2"></div>
                        <div class="skeleton-loader w-100 mb-2"></div>
                        <div class="skeleton-loader w-100 mb-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcement Detail Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">Announcement Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge bg-primary badge-custom" id="modalCategory">Category</span>
                    <small class="text-muted" id="modalDate">Published: Date</small>
                </div>
                <div id="modalContent">
                    <!-- Announcement content will be loaded here -->
                </div>
                <div class="mt-4" id="modalAttachments">
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
    // Default filters
    let currentPage = 1;
    let currentCategory = null;
    let currentAudience = null;
    let currentSearch = '';
    let currentSort = 'newest';
    
    console.log('Announcements page initialized');
    
    // Load everything
    loadCategories();
    loadAnnouncements();
    loadFeaturedAnnouncements();
    
    // Search functionality
    $('#searchAnnouncements').on('keyup', function() {
        currentSearch = $(this).val();
        currentPage = 1; // Reset to first page on new search
        loadAnnouncements();
    });
    
    // Sort dropdown functionality
    $('.sort-option').click(function(e) {
        e.preventDefault();
        currentSort = $(this).data('sort');
        $('#sortDropdown').text($(this).text());
        loadAnnouncements();
    });
    
    // Load categories
    function loadCategories() {
        $.ajax({
            url: '/api/announcements/public',
            method: 'GET',
            data: { get_categories: true },
            success: function(response) {
                // Clear skeleton loaders
                $('#categoryContainer').empty();
                
                // Add "All" category option
                $('#categoryContainer').append(`
                    <div class="me-2 mb-2">
                        <span class="badge bg-primary badge-custom category-pill active" data-category-id="all">
                            All (${response.total_announcements})
                        </span>
                    </div>
                `);
                
                // Add individual categories
                response.categories.forEach(function(category) {
                    if (category.announcements_count > 0) {
                        let color = category.color || '#6c757d';
                        $('#categoryContainer').append(`
                            <div class="me-2 mb-2">
                                <span class="badge badge-custom category-pill" 
                                      style="background-color: ${color}" 
                                      data-category-id="${category.id}">
                                    ${category.name} (${category.announcements_count})
                                </span>
                            </div>
                        `);
                    }
                });
                
                // Add audience filters
                $('#audienceFiltersContainer').empty();
                
                // Add "All Audiences" option
                $('#audienceFiltersContainer').append(`
                    <a href="#" class="list-group-item list-group-item-action active audience-filter" data-audience="all">
                        All Audiences
                    </a>
                `);
                
                // Get unique audiences from the categories
                let audiences = new Set();
                
                $.ajax({
                    url: '/api/announcements/public',
                    method: 'GET',
                    success: function(data) {
                        data.data.forEach(function(announcement) {
                            audiences.add(announcement.target_audience);
                        });
                        
                        // Add audience filter options
                        audiences.forEach(function(audience) {
                            $('#audienceFiltersContainer').append(`
                                <a href="#" class="list-group-item list-group-item-action audience-filter" data-audience="${audience}">
                                    ${audience}
                                </a>
                            `);
                        });
                        
                        // Click handler for audience filters
                        $('.audience-filter').click(function(e) {
                            e.preventDefault();
                            $('.audience-filter').removeClass('active');
                            $(this).addClass('active');
                            
                            currentAudience = $(this).data('audience');
                            if (currentAudience === 'all') {
                                currentAudience = null;
                            }
                            
                            currentPage = 1; // Reset to first page
                            loadAnnouncements();
                        });
                    }
                });
                
                // Click handler for category pills
                $('.category-pill').click(function() {
                    $('.category-pill').removeClass('active');
                    $(this).addClass('active');
                    
                    currentCategory = $(this).data('category-id');
                    if (currentCategory === 'all') {
                        currentCategory = null;
                        $('#announcementsTitle').text('All Announcements');
                    } else {
                        $('#announcementsTitle').text($(this).text().split('(')[0].trim() + ' Announcements');
                    }
                    
                    currentPage = 1; // Reset to first page
                    loadAnnouncements();
                });
            },
            error: function(xhr) {
                console.error('Error loading categories:', xhr);
            }
        });
    }
    
    // Load announcements
    function loadAnnouncements() {
        const params = {
            page: currentPage,
            per_page: 5 // Adjust as needed
        };
        
        // Add filters if selected
        if (currentCategory) params.category_id = currentCategory;
        if (currentAudience) params.target_audience = currentAudience;
        if (currentSearch) params.search = currentSearch;
        
        // Add sort parameters
        if (currentSort === 'newest') {
            params.sort_by = 'publish_date';
            params.sort_dir = 'desc';
        } else if (currentSort === 'oldest') {
            params.sort_by = 'publish_date';
            params.sort_dir = 'asc';
        } else if (currentSort === 'alphabetical') {
            params.sort_by = 'title';
            params.sort_dir = 'asc';
        }
        
        $.ajax({
            url: '/api/announcements/public',
            method: 'GET',
            data: params,
            success: function(response) {
                // Clear container
                $('#announcementsContainer').empty();
                
                if (response.data.length === 0) {
                    // Show no announcements message
                    $('#announcementsContainer').html(`
                        <div class="no-announcements">
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <h5>No announcements found</h5>
                            <p class="text-muted">Try adjusting your filters or search criteria</p>
                        </div>
                    `);
                    $('#announcementsPagination').empty();
                    return;
                }
                
                // Add announcements
                response.data.forEach(function(announcement, index) {
                    // Format dates
                    const publishDate = new Date(announcement.publish_date).toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                    
                    // Create announcement card
                    const card = `
                        <div class="announcement-card p-3 mb-3 rounded ${announcement.is_featured ? 'featured' : ''}" 
                             data-id="${announcement.id}" style="${announcement.category.color ? `border-left-color: ${announcement.category.color};` : ''}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-1">${announcement.title}</h5>
                                ${announcement.is_featured ? '<span class="badge bg-warning text-dark">Featured</span>' : ''}
                            </div>
                            <div class="mb-2">
                                <span class="badge badge-custom" style="background-color: ${announcement.category.color || '#6c757d'}">
                                    ${announcement.category.name}
                                </span>
                                <span class="badge bg-info badge-custom ms-2">${announcement.target_audience}</span>
                            </div>
                            <div class="truncate-content mb-3">
                                ${stripHtml(announcement.content).substring(0, 150)}...
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted announcement-meta">
                                    <i class="far fa-calendar-alt me-1"></i> ${publishDate}
                                    <i class="far fa-eye ms-3 me-1"></i> ${announcement.views || 0} views
                                </small>
                                <a href="/announcements/${announcement.id}" class="btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    `;
                    
                    $('#announcementsContainer').append(card);
                    
                    // Add divider except for last item
                    if (index < response.data.length - 1) {
                        $('#announcementsContainer').append('<hr class="my-0">');
                    }
                });
                
                // Set up pagination
                setupPagination(response);
            },
            error: function(xhr) {
                console.error('Error loading announcements:', xhr);
            }
        });
    }
    
    // Load featured announcements for sidebar
    function loadFeaturedAnnouncements() {
        $.ajax({
            url: '/api/announcements/public',
            method: 'GET',
            data: {
                is_featured: true,
                per_page: 3
            },
            success: function(response) {
                // Clear container
                $('#featuredAnnouncementsContainer').empty();
                
                if (response.data.length === 0) {
                    $('#featuredAnnouncementsContainer').html(`
                        <div class="p-3 text-center text-muted">
                            <i class="fas fa-star mb-2"></i>
                            <p class="mb-0">No featured announcements</p>
                        </div>
                    `);
                    return;
                }
                
                // Add featured announcements
                response.data.forEach(function(announcement, index) {
                    // Format date
                    const publishDate = new Date(announcement.publish_date).toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    const featuredItem = `
                        <a href="/announcements/${announcement.id}" class="text-decoration-none">
                            <div class="p-3 border-bottom featured-item" data-id="${announcement.id}">
                                <h6 class="mb-1 text-body">${announcement.title}</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge badge-custom" style="background-color: ${announcement.category.color || '#6c757d'}">
                                        ${announcement.category.name}
                                    </span>
                                    <small class="text-muted">${publishDate}</small>
                                </div>
                                <p class="mb-0 small text-muted">${stripHtml(announcement.content).substring(0, 80)}...</p>
                            </div>
                        </a>
                    `;
                    
                    $('#featuredAnnouncementsContainer').append(featuredItem);
                });
            },
            error: function(xhr) {
                console.error('Error loading featured announcements:', xhr);
            }
        });
    }
    
    // Set up pagination
    function setupPagination(response) {
        const pagination = $('#announcementsPagination');
        pagination.empty();
        
        // Don't show pagination if only one page
        if (response.last_page <= 1) {
            return;
        }
        
        // Previous page link
        const prevDisabled = response.current_page === 1 ? 'disabled' : '';
        pagination.append(`
            <li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" data-page="${response.current_page - 1}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        `);
        
        // Page links
        for (let i = 1; i <= response.last_page; i++) {
            // Show first page, last page, and pages around current page
            if (i === 1 || i === response.last_page || (i >= response.current_page - 1 && i <= response.current_page + 1)) {
                const active = i === response.current_page ? 'active' : '';
                pagination.append(`
                    <li class="page-item ${active}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            } else if (i === response.current_page - 2 || i === response.current_page + 2) {
                // Add ellipsis
                pagination.append(`
                    <li class="page-item disabled">
                        <a class="page-link" href="#">...</a>
                    </li>
                `);
            }
        }
        
        // Next page link
        const nextDisabled = response.current_page === response.last_page ? 'disabled' : '';
        pagination.append(`
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" data-page="${response.current_page + 1}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        `);
        
        // Add click handler for pagination
        $('.page-link').click(function(e) {
            e.preventDefault();
            
            if ($(this).parent().hasClass('disabled')) {
                return;
            }
            
            currentPage = $(this).data('page');
            loadAnnouncements();
            
            // Scroll to top of announcements container
            $('html, body').animate({
                scrollTop: $('#announcementsContainer').offset().top - 100
            }, 200);
        });
    }
    
    // Helper function to strip HTML tags
    function stripHtml(html) {
        const temp = document.createElement('div');
        temp.innerHTML = html;
        return temp.textContent || temp.innerText || '';
    }
});
</script>
@endsection