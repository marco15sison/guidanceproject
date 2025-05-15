<!-- resources/views/faculty/dashboard.blade.php -->
@extends('layouts.faculty')

@section('title', 'Dashboard')

@section('page_title', 'Faculty Dashboard')

@section('custom_styles')
<style>
    .dashboard-container {
        margin-bottom: 30px;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        padding: 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 15px;
        color: white;
    }
    
    .stat-icon.students {
        background-color: #4361ee;
    }
    
    .stat-icon.reports {
        background-color: #3a86ff;
    }
    
    .stat-icon.pending {
        background-color: #ff9e00;
    }
    
    .stat-icon.resolved {
        background-color: #38b000;
    }
    
    .stat-content {
        flex: 1;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
        line-height: 1;
    }
    
    .stat-label {
        color: #666;
        font-size: 14px;
        margin: 0;
    }
    
    .dashboard-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    
    .dashboard-card-header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .dashboard-card-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0;
    }
    
    .dashboard-card-body {
        padding: 20px;
    }
    
    .activity-item {
        display: flex;
        margin-bottom: 15px;
        position: relative;
    }
    
    .activity-item:not(:last-child):before {
        content: "";
        position: absolute;
        left: 22px;
        top: 35px;
        bottom: -15px;
        width: 2px;
        background-color: #e0e0e0;
    }
    
    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-right: 15px;
        color: white;
        z-index: 1;
    }
    
    .activity-icon.report {
        background-color: #3a86ff;
    }
    
    .activity-icon.feedback {
        background-color: #38b000;
    }
    
    .activity-icon.alert {
        background-color: #ff0a54;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    
    .activity-text {
        color: #666;
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .activity-time {
        color: #999;
        font-size: 12px;
    }
    
    .student-card {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.2s;
        cursor: pointer;
        margin-bottom: 10px;
    }
    
    .student-card:hover {
        background-color: #f8f9fa;
    }
    
    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }
    
    .student-info {
        flex: 1;
    }
    
    .student-info h6 {
        margin-bottom: 3px;
        color: #333;
    }
    
    .student-info p {
        margin-bottom: 0;
        color: #666;
        font-size: 13px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-processing {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .status-resolved {
        background-color: #d4edda;
        color: #155724;
    }
    
    .calendar-event {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 6px;
        border-left: 4px solid #3a86ff;
        background-color: #f8f9fa;
        margin-bottom: 10px;
    }
    
    .calendar-event-time {
        font-weight: 600;
        min-width: 75px;
    }
    
    .calendar-event-title {
        font-weight: 500;
        flex: 1;
    }
    
    .tabbed-card .nav-tabs {
        border-bottom: none;
        padding: 0 20px;
    }
    
    .tabbed-card .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
        padding: 15px 15px;
    }
    
    .tabbed-card .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 2px solid var(--accent-color);
    }
    
    .chart-container {
        height: 300px;
    }
    
    .report-quick-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .welcome-banner {
        background-color: var(--primary-color);
        border-radius: 10px;
        padding: 20px 25px;
        color: white;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-image: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .welcome-content h2 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .welcome-content p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .welcome-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-welcome {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-welcome:hover {
        background-color: rgba(255,255,255,0.3);
        color: white;
    }
    
    .todo-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .todo-item:hover {
        background-color: #f8f9fa;
    }
    
    .todo-checkbox {
        margin-right: 15px;
    }
    
    .todo-label {
        flex: 1;
        margin-bottom: 0;
    }
    
    .todo-date {
        color: #999;
        font-size: 12px;
    }
    
    .announcements-list {
        margin-top: 10px;
    }
    
    .announcement-item {
        padding: 15px;
        border-radius: 6px;
        background-color: #f8f9fa;
        margin-bottom: 10px;
    }
    
    .announcement-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .announcement-title {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .announcement-date {
        font-size: 12px;
        color: #999;
    }
    
    .announcement-content {
        color: #666;
        font-size: 14px;
    }
    
    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <h2>Welcome, {{ Auth::user()->name }}!</h2>
            <p>{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="welcome-actions">
            <a href="{{ route('faculty.reports') }}" class="btn btn-welcome">
                <i class="fas fa-file-alt me-2"></i> View Reports
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon students">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">47</div>
                <p class="stat-label">STUDENTS HANDLED</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon reports">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">12</div>
                <p class="stat-label">TOTAL REPORTS</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">5</div>
                <p class="stat-label">PENDING REPORTS</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon resolved">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">7</div>
                <p class="stat-label">RESOLVED REPORTS</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Reports -->
        <div class="col-lg-7 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="dashboard-card-title">
                        <i class="fas fa-file-alt me-2"></i> Recent Reports
                    </h5>
                    <a href="{{ route('faculty.reports') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="dashboard-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Juan Dela Cruz</td>
                                    <td>Behavioral</td>
                                    <td>May 2, 2025</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Maria Santos</td>
                                    <td>Academic</td>
                                    <td>Apr 28, 2025</td>
                                    <td><span class="status-badge status-processing">Processing</span></td>
                                </tr>
                                <tr>
                                    <td>Pedro Reyes</td>
                                    <td>Emotional</td>
                                    <td>Apr 25, 2025</td>
                                    <td><span class="status-badge status-resolved">Resolved</span></td>
                                </tr>
                                <tr>
                                    <td>Ana Gonzales</td>
                                    <td>Social</td>
                                    <td>Apr 20, 2025</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="report-quick-actions">
                        <a href="{{ route('faculty.reports') }}" class="btn btn-primary">
                            <i class="fas fa-file-alt me-2"></i> Manage Reports
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fas fa-filter me-2"></i> Filter Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-5 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="dashboard-card-title">
                        <i class="fas fa-bell me-2"></i> Recent Activities
                    </h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="activity-item">
                        <div class="activity-icon report">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New Report Submitted</div>
                            <div class="activity-text">You submitted a behavioral concern report for Juan Dela Cruz.</div>
                            <div class="activity-time">Today, 10:25 AM</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon feedback">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Guidance Feedback</div>
                            <div class="activity-text">The guidance office provided feedback on Maria Santos's report.</div>
                            <div class="activity-time">Yesterday, 3:40 PM</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon alert">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Follow-up Required</div>
                            <div class="activity-text">A follow-up is required for Pedro Reyes's emotional support report.</div>
                            <div class="activity-time">Apr 25, 2025</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon report">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Report Status Updated</div>
                            <div class="activity-text">Ana Gonzales's report has been updated to "Processing".</div>
                            <div class="activity-time">Apr 22, 2025</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Upcoming Events -->
        <div class="col-lg-5 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="dashboard-card-title">
                        <i class="fas fa-calendar-alt me-2"></i> Today's Schedule
                    </h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="calendar-event">
                        <div class="calendar-event-time">9:00 AM</div>
                        <div class="calendar-event-title">Faculty Meeting</div>
                    </div>
                    <div class="calendar-event">
                        <div class="calendar-event-time">11:30 AM</div>
                        <div class="calendar-event-title">Student Counseling Session</div>
                    </div>
                    <div class="calendar-event">
                        <div class="calendar-event-time">2:00 PM</div>
                        <div class="calendar-event-title">Department Coordination</div>
                    </div>
                    <div class="calendar-event">
                        <div class="calendar-event-time">4:00 PM</div>
                        <div class="calendar-event-title">Guidance Committee Meeting</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- To-Do List -->
        <div class="col-lg-3 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="dashboard-card-title">
                        <i class="fas fa-tasks me-2"></i> To-Do List
                    </h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="todo-item">
                        <input type="checkbox" class="form-check-input todo-checkbox" id="todo1">
                        <label class="todo-label" for="todo1">Submit student progress reports</label>
                        <span class="todo-date">Today</span>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" class="form-check-input todo-checkbox" id="todo2">
                        <label class="todo-label" for="todo2">Follow up on Juan's counseling</label>
                        <span class="todo-date">Today</span>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" class="form-check-input todo-checkbox" id="todo3">
                        <label class="todo-label" for="todo3">Prepare guidance materials</label>
                        <span class="todo-date">Tomorrow</span>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" class="form-check-input todo-checkbox" id="todo4">
                        <label class="todo-label" for="todo4">Review pending student reports</label>
                        <span class="todo-date">May 6</span>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" class="form-check-input todo-checkbox" id="todo5">
                        <label class="todo-label" for="todo5">Coordinate with guidance counselor</label>
                        <span class="todo-date">May 7</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="dashboard-card-title">
                        <i class="fas fa-bullhorn me-2"></i> Announcements
                    </h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="announcements-list">
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <div class="announcement-title">Guidance System Update</div>
                                <div class="announcement-date">May 3, 2025</div>
                            </div>
                            <div class="announcement-content">
                                The student guidance reporting system has been updated with new features. Please check the updated guidelines.
                            </div>
                        </div>
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <div class="announcement-title">Monthly Reports Due</div>
                                <div class="announcement-date">May 1, 2025</div>
                            </div>
                            <div class="announcement-content">
                                All faculty members are reminded to submit their monthly student guidance reports by May 10.
                            </div>
                        </div>
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <div class="announcement-title">Training Workshop</div>
                                <div class="announcement-date">Apr 28, 2025</div>
                            </div>
                            <div class="announcement-content">
                                A training workshop on "Identifying Student Mental Health Issues" will be held on May 15. Registration is open.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize any dashboard components
        $('.todo-checkbox').change(function() {
            if(this.checked) {
                $(this).closest('.todo-item').find('.todo-label').css('text-decoration', 'line-through');
            } else {
                $(this).closest('.todo-item').find('.todo-label').css('text-decoration', 'none');
            }
        });
        
        // Quick action button handling
        $('.btn-welcome').click(function() {
            window.location.href = "{{ route('faculty.reports') }}";
        });
    });
</script>
@endsection