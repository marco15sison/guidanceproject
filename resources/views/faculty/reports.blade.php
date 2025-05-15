<!-- resources/views/faculty/reports/index.blade.php -->
@extends('layouts.faculty')

@section('title', 'Faculty Reports')

@section('page_title', 'Student Reports')

@section('custom_styles')
<style>
    .report-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .report-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .report-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    
    .report-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .report-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .report-table th {
        background-color: var(--light-accent);
        color: var(--primary-color);
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .report-table th:first-child {
        border-left: 1px solid #e0e0e0;
        border-top-left-radius: 8px;
    }
    
    .report-table th:last-child {
        border-right: 1px solid #e0e0e0;
        border-top-right-radius: 8px;
    }
    
    .report-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .report-table tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
        border-left: 1px solid #e0e0e0;
    }
    
    .report-table tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
        border-right: 1px solid #e0e0e0;
    }
    
    .report-table td:first-child {
        border-left: 1px solid #e0e0e0;
    }
    
    .report-table td:last-child {
        border-right: 1px solid #e0e0e0;
    }
    
    .report-table tr:hover {
        background-color: var(--light-accent);
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .status-pending {
        background-color: #fff8e1;
        color: #f57c00;
    }
    
    .status-processing {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    
    .status-resolved {
        background-color: #e8f5e9;
        color: #388e3c;
    }
    
    .status-rejected {
        background-color: #ffebee;
        color: #d32f2f;
    }
    
    .report-actions {
        display: flex;
        gap: 5px;
    }
    
    .btn-action {
        padding: 4px 8px;
        font-size: 0.8rem;
        border-radius: 4px;
    }
    
    .severity-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .severity-low {
        background-color: #4caf50;
    }
    
    .severity-medium {
        background-color: #ff9800;
    }
    
    .severity-high {
        background-color: #f44336;
    }
    
    .report-stats {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        flex: 1;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 15px;
        display: flex;
        align-items: center;
    }
    
    .stat-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 15px;
        color: white;
    }
    
    .stat-icon.total {
        background-color: var(--primary-color);
    }
    
    .stat-icon.pending {
        background-color: #f57c00;
    }
    
    .stat-icon.processing {
        background-color: #1976d2;
    }
    
    .stat-icon.resolved {
        background-color: #388e3c;
    }
    
    .stat-content h4 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 2px;
    }
    
    .stat-content p {
        margin: 0;
        color: #666;
        font-size: 0.8rem;
    }
    
    .search-container {
        position: relative;
        max-width: 300px;
    }
    
    .search-container input {
        width: 100%;
        padding: 8px 12px 8px 35px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
    }
    
    .search-container i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }
    
    .empty-state h3 {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }
    
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    
    .pagination-info {
        color: #666;
        font-size: 0.9rem;
    }
    
    .report-type-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .type-behavioral {
        background-color: #ffecb3;
        color: #ff8f00;
    }
    
    .type-academic {
        background-color: #bbdefb;
        color: #1565c0;
    }
    
    .type-emotional {
        background-color: #f8bbd0;
        color: #c2185b;
    }
    
    .type-social {
        background-color: #c8e6c9;
        color: #2e7d32;
    }
    
    .type-referral {
        background-color: #e1bee7;
        color: #7b1fa2;
    }
    
    .type-other {
        background-color: #e0e0e0;
        color: #616161;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="report-stats">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h4>12</h4>
                <p>TOTAL REPORTS</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h4>5</h4>
                <p>PENDING</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon processing">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="stat-content">
                <h4>3</h4>
                <p>PROCESSING</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon resolved">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h4>4</h4>
                <p>RESOLVED</p>
            </div>
        </div>
    </div>

    <div class="report-container">
        <div class="report-header">
            <h5 class="report-title">
                <i class="fas fa-file-alt me-2"></i> Student Reports
            </h5>
            {{-- <a href="{{ route('faculty.reports.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New Report
            </a> --}}
        </div>
        
        <div class="d-flex justify-content-between mb-4">
            <div class="report-filters">
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="resolved">Resolved</option>
                    <option value="rejected">Rejected</option>
                </select>
                
                <select class="form-select form-select-sm" id="typeFilter">
                    <option value="">All Types</option>
                    <option value="behavioral">Behavioral</option>
                    <option value="academic">Academic</option>
                    <option value="emotional">Emotional/Mental</option>
                    <option value="social">Social</option>
                    <option value="referral">Referral</option>
                    <option value="other">Other</option>
                </select>
                
                <select class="form-select form-select-sm" id="severityFilter">
                    <option value="">All Severity</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                
                <button class="btn btn-sm btn-outline-secondary" id="resetFilters">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
            </div>
            
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search reports...">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Report Type</th>
                        <th>Title</th>
                        <th>Severity</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>22-SC-3905</td>
                        <td>Marco Sison</td>
                        <td><span class="report-type-badge type-behavioral">Behavioral</span></td>
                        <td>Disruptive classroom behavior</td>
                        <td>
                            <span class="severity-indicator severity-medium"></span> Medium
                        </td>
                        <td>May 02, 2025</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>
                            {{-- <div class="report-actions">
                                <a href="{{ route('faculty.reports.show', 1) }}" class="btn btn-sm btn-outline-primary btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faculty.reports.edit', 1) }}" class="btn btn-sm btn-outline-secondary btn-action" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div> --}}
                        </td>
                    </tr>
                    <tr>
                        <td>22-SC-0001</td>
                        <td>Maria Santos</td>
                        <td><span class="report-type-badge type-academic">Academic</span></td>
                        <td>Declining academic performance</td>
                        <td>
                            <span class="severity-indicator severity-medium"></span> Medium
                        </td>
                        <td>Apr 28, 2025</td>
                        <td><span class="status-badge status-processing">Processing</span></td>
                        <td>
                            <div class="report-actions">
                                {{-- <a href="{{ route('faculty.reports.show', 2) }}" class="btn btn-sm btn-outline-primary btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faculty.reports.edit', 2) }}" class="btn btn-sm btn-outline-secondary btn-action" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a> --}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>22-SC-0002</td>
                        <td>Pedro Reyes</td>
                        <td><span class="report-type-badge type-emotional">Emotional</span></td>
                        <td>Signs of emotional distress</td>
                        <td>
                            <span class="severity-indicator severity-high"></span> High
                        </td>
                        <td>Apr 25, 2025</td>
                        <td><span class="status-badge status-resolved">Resolved</span></td>
                        <td>
                            <div class="report-actions">
                                {{-- <a href="{{ route('faculty.reports.show', 3) }}" class="btn btn-sm btn-outline-primary btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faculty.reports.edit', 3) }}" class="btn btn-sm btn-outline-secondary btn-action disabled" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a> --}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>22-SC-0003</td>
                        <td>Ana Gonzales</td>
                        <td><span class="report-type-badge type-social">Social</span></td>
                        <td>Social isolation concerns</td>
                        <td>
                            <span class="severity-indicator severity-low"></span> Low
                        </td>
                        <td>Apr 20, 2025</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>
                            <div class="report-actions">
                                {{-- <a href="{{ route('faculty.reports.show', 4) }}" class="btn btn-sm btn-outline-primary btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faculty.reports.edit', 4) }}" class="btn btn-sm btn-outline-secondary btn-action" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a> --}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>22-SC-0004</td>
                        <td>Marco Cruz</td>
                        <td><span class="report-type-badge type-referral">Referral</span></td>
                        <td>Career guidance referral</td>
                        <td>
                            <span class="severity-indicator severity-low"></span> Low
                        </td>
                        <td>Apr 18, 2025</td>
                        <td><span class="status-badge status-processing">Processing</span></td>
                        <td>
                            <div class="report-actions">
                                {{-- <a href="{{ route('faculty.reports.show', 5) }}" class="btn btn-sm btn-outline-primary btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faculty.reports.edit', 5) }}" class="btn btn-sm btn-outline-secondary btn-action" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a> --}}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing 1 to 5 of 12 entries
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Search functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".report-table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        // Filter functionality
        $("#statusFilter, #typeFilter, #severityFilter").change(function() {
            applyFilters();
        });
        
        // Reset filters
        $("#resetFilters").click(function() {
            $("#statusFilter, #typeFilter, #severityFilter").val("");
            applyFilters();
        });
        
        function applyFilters() {
            var statusFilter = $("#statusFilter").val().toLowerCase();
            var typeFilter = $("#typeFilter").val().toLowerCase();
            var severityFilter = $("#severityFilter").val().toLowerCase();
            
            $(".report-table tbody tr").filter(function() {
                var row = $(this);
                var status = row.find(".status-badge").text().toLowerCase();
                var type = row.find(".report-type-badge").text().toLowerCase();
                var severity = row.find("td:nth-child(5)").text().toLowerCase();
                
                var statusMatch = statusFilter === "" || status.indexOf(statusFilter) > -1;
                var typeMatch = typeFilter === "" || type.indexOf(typeFilter) > -1;
                var severityMatch = severityFilter === "" || severity.indexOf(severityFilter) > -1;
                
                row.toggle(statusMatch && typeMatch && severityMatch);
            });
        }
    });
</script>
@endsection