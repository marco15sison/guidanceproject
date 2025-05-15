<!-- resources/views/faculty/reports/referrals.blade.php -->
@extends('layouts.faculty')

@section('title', 'My Referrals')

@section('page_title', 'My Report Referrals')

@section('custom_styles')
<style>
    .referrals-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .referrals-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .referrals-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    
    .referrals-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .referrals-table th {
        background-color: #f3e5f5;
        color: #7b1fa2;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-top: 1px solid #e1bee7;
        border-bottom: 1px solid #e1bee7;
    }
    
    .referrals-table th:first-child {
        border-left: 1px solid #e1bee7;
        border-top-left-radius: 8px;
    }
    
    .referrals-table th:last-child {
        border-right: 1px solid #e1bee7;
        border-top-right-radius: 8px;
    }
    
    .referrals-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .referrals-table tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
        border-left: 1px solid #e0e0e0;
    }
    
    .referrals-table tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
        border-right: 1px solid #e0e0e0;
    }
    
    .referrals-table td:first-child {
        border-left: 1px solid #e0e0e0;
    }
    
    .referrals-table td:last-child {
        border-right: 1px solid #e0e0e0;
    }
    
    .referrals-table tr:hover {
        background-color: rgba(225, 190, 231, 0.1);
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
    
    .referral-tabs {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .referral-tab {
        padding: 12px 20px;
        font-weight: 500;
        cursor: pointer;
        position: relative;
        color: #666;
    }
    
    .referral-tab.active {
        color: #7b1fa2;
    }
    
    .referral-tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #7b1fa2;
    }
    
    .referral-tab .badge {
        margin-left: 5px;
        background-color: #7b1fa2;
        color: white;
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
    
    .unread-indicator {
        width: 10px;
        height: 10px;
        background-color: #f44336;
        border-radius: 50%;
        display: inline-block;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="referrals-container">
        <div class="referrals-header">
            <h5 class="referrals-title">
                <i class="fas fa-share-square me-2"></i> My Report Referrals
            </h5>
            <div>
                <a href="{{ route('faculty.reports.refer') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> New Referral
                </a>
                <a href="{{ route('faculty.dashboard') }}" class="btn btn-outline-secondary btn-sm ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
        
        <div class="referral-tabs">
            <div class="referral-tab active" data-tab="all">
                All <span class="badge rounded-pill">{{ $referrals->total() }}</span>
            </div>
            <div class="referral-tab" data-tab="pending">
                Pending <span class="badge rounded-pill">{{ $referrals->where('status', 'pending')->count() }}</span>
            </div>
            <div class="referral-tab" data-tab="in-progress">
                In Progress <span class="badge rounded-pill">{{ $referrals->whereIn('status', ['reviewing', 'action_required', 'accepted'])->count() }}</span>
            </div>
            <div class="referral-tab" data-tab="completed">
                Completed <span class="badge rounded-pill">{{ $referrals->whereIn('status', ['resolved', 'declined', 'withdrawn'])->count() }}</span>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mb-3">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search referrals...">
            </div>
        </div>
        
        @if(count($referrals) > 0)
        <div class="table-responsive">
            <table class="referrals-table">
                <thead>
                    <tr>
                        <th>Referral ID</th>
                        <th>Original Report</th>
                        <th>Student</th>
                        <th>Referral Type</th>
                        <th>Admin Department</th>
                        <th>Priority</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($referrals as $referral)
                    <tr class="referral-row {{ $referral->status }}">
                        <td>
                            {{ $referral->referral_id }}
                            @if($referral->messages->where('sender_type', 'admin')->where('read_at', null)->count() > 0)
                                <span class="unread-indicator" title="Unread messages"></span>
                            @endif
                        </td>
                        <td><a href="{{ route('faculty.reports.show', $referral->report_id) }}">#{{ $referral->report->report_id }}</a></td>
                        <td>{{ $referral->report->student->name }}</td>
                        <td><span class="referral-type-badge type-{{ $referral->referral_type }}">{{ ucfirst($referral->referral_type) }}</span></td>
                        <td>{{ $referral->adminDepartment ? $referral->adminDepartment->name : 'Unknown' }}</td>
                        <td>
                            <span class="priority-indicator priority-{{ $referral->priority }}"></span> {{ ucfirst($referral->priority) }}
                        </td>
                        <td>{{ $referral->created_at->format('M d, Y') }}</td>
                        <td><span class="admin-status-badge admin-{{ $referral->status }}">{{ $referral->formatted_status }}</span></td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('faculty.reports.referral.view', $referral->referral_id) }}" class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($referral->status === 'pending')
                                <a href="{{ route('faculty.reports.referral.edit', $referral->referral_id) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @endif
                                
                                @if($referral->status === 'action_required')
                                <a href="{{ route('faculty.reports.referral.respond', $referral->referral_id) }}" class="btn btn-sm btn-primary" title="Respond">
                                    <i class="fas fa-reply"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $referrals->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-share-square"></i>
            <h3>No Referrals Yet</h3>
            <p>You haven't referred any reports to administration yet.</p>
            <a href="{{ route('faculty.reports.refer') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Create Referral
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Tab switching
        $('.referral-tab').click(function() {
            $('.referral-tab').removeClass('active');
            $(this).addClass('active');
            
            var tabType = $(this).data('tab');
            
            if (tabType === 'all') {
                $('.referral-row').show();
            } else if (tabType === 'pending') {
                $('.referral-row').hide();
                $('.referral-row.pending').show();
            } else if (tabType === 'in-progress') {
                $('.referral-row').hide();
                $('.referral-row.reviewing, .referral-row.action_required, .referral-row.accepted').show();
            } else if (tabType === 'completed') {
                $('.referral-row').hide();
                $('.referral-row.resolved, .referral-row.declined, .referral-row.withdrawn').show();
            }
        });
        
        // Search functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".referrals-table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection