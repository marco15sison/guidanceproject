<!-- resources/views/faculty/reports/refer-list.blade.php -->
@extends('layouts.faculty')

@section('title', 'Select Report to Refer')

@section('page_title', 'Select Student Report to Refer')

@section('custom_styles')
<style>
    .refer-list-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .refer-list-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .refer-list-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    
    .refer-list-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .refer-list-table th {
        background-color: var(--light-accent);
        color: var(--primary-color);
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .refer-list-table th:first-child {
        border-left: 1px solid #e0e0e0;
        border-top-left-radius: 8px;
    }
    
    .refer-list-table th:last-child {
        border-right: 1px solid #e0e0e0;
        border-top-right-radius: 8px;
    }
    
    .refer-list-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .refer-list-table tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
        border-left: 1px solid #e0e0e0;
    }
    
    .refer-list-table tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
        border-right: 1px solid #e0e0e0;
    }
    
    .refer-list-table td:first-child {
        border-left: 1px solid #e0e0e0;
    }
    
    .refer-list-table td:last-child {
        border-right: 1px solid #e0e0e0;
    }
    
    .refer-list-table tr:hover {
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
    
    .info-icon {
        background-color: #f5f5f5;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 5px;
        color: #757575;
        font-size: 0.8rem;
        cursor: help;
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
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="refer-list-container">
        <div class="refer-list-header">
            <h5 class="refer-list-title">
                <i class="fas fa-share-square me-2"></i> Select Report to Refer
                <span class="info-icon" data-bs-toggle="tooltip" title="Select a student report to refer to an administrative department">
                    <i class="fas fa-info"></i>
                </span>
            </h5>
            <a href="{{ route('faculty.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="mb-4 d-flex justify-content-end">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search reports...">
            </div>
        </div>
        
        @if(count($reports) > 0)
        <div class="table-responsive">
            <table class="refer-list-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Report Type</th>
                        <th>Title</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->report_id }}</td>
                        <td>{{ $report->student->name }}</td>
                        <td><span class="report-type-badge type-{{ $report->type }}">{{ ucfirst($report->type) }}</span></td>
                        <td>{{ $report->title }}</td>
                        <td>
                            <span class="severity-indicator severity-{{ $report->severity }}"></span> {{ ucfirst($report->severity) }}
                        </td>
                        <td><span class="status-badge status-{{ $report->status }}">{{ ucfirst($report->status) }}</span></td>
                        <td>{{ $report->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('faculty.reports.refer.form', $report->id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-share-square me-1"></i> Refer
                                </a>
                                <a href="{{ route('faculty.reports.show', $report->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h3>No Reports Available for Referral</h3>
            <p>There are no student reports available for referral at this time.</p>
            <a href="{{ route('faculty.reports.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Create New Report
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Search functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".refer-list-table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection