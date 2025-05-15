<!-- resources/views/layouts/student.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Student</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
    --primary-color: #f0ca21; /* Yellow color */
    --secondary-color: #2c5f8e; /* Blue color */
    --accent-color: #4d8bc9;
    --light-accent: #e9f0f9;
    --sidebar-width: 250px;
    --sidebar-collapsed-width: 70px;
    --yellow-section-height: 30%; /* Controls how much of the sidebar is yellow */
}
        
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Updated Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: var(--secondary-color);
            color: white;
            transition: all 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 1000;
            width: var(--sidebar-width);
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            padding: 20px 15px;
            background-color: var(--primary-color);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 12px 20px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left: 4px solid var(--primary-color);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: white;
            border-left: 4px solid var(--primary-color);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar.collapsed .nav-link span {
            display: none;
        }
        
        /* User Info Section */
        .user-info {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-role {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s;
            background-color: var(--primary-color) !important;
        }
        
        .content-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            width: calc(100% - var(--sidebar-width));
        }
        
        .content-wrapper.expanded {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }
        
        /* Navbar Styling */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .page-title {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        /* Button Styling */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #4f451a;
            border-color: #4f451a;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-secondary:hover {
            background-color: #24507a;
            border-color: #24507a;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .stat-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .stat-icon {
            font-size: 2rem;
            color: var(--accent-color);
        }
        
        .table th {
            font-weight: 600;
            background-color: var(--light-accent);
        }

        /* Badge Styling */
        .badge.bg-danger {
            background-color: #dc3545 !important;
        }
        
        /* Dropdown Styling */
        .dropdown-item.active, 
        .dropdown-item:active {
            background-color: var(--accent-color);
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            .content-wrapper.expanded {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @yield('custom_styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <h5 id="sidebar-title" class="sidebar-title mb-0">Student</h5>
                <button class="btn btn-link text-light p-0 d-none d-md-block" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <!-- User Info Section -->
            <div class="user-info">
                @if(Auth::check())
                    <div class="user-avatar">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="rounded-circle" style="width: 40px; height: 40px;">
                        @else
                            <div class="avatar-circle rounded-circle text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="ms-2">
                        <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role text-light-50">{{ ucfirst(Auth::user()->user_type) }}</div>
                    </div>
                @endif
            </div>
            
            <!-- Navigation -->
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}" class="nav-link @if(request()->routeIs('student.dashboard')) active @endif">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('student.inventory_form') }}" class="nav-link @if(request()->routeIs('student.inventory_form*')) active @endif">
                        <i class="fas fa-file-alt"></i>
                        <span>Inventory</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('student.councelling') }}" class="nav-link @if(request()->routeIs('student.councelling*') || request()->routeIs('student.history*')) active @endif">
                        <i class="fas fa-comments"></i>
                        <span>Counselling</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('announcements.index') }}" class="nav-link @if(request()->routeIs('announcements.index*') || request()->routeIs('student.history*')) active @endif">
                        <i class="fas fa-bullhorn"></i>
                        <span>Announcements</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Content -->
        <div class="content-wrapper" id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="btn d-md-none" id="mobileSidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        @yield('page_title', 'Dashboard')
                    </div>
                    <div class="ms-auto d-flex align-items-center">
                        <div class="position-relative me-3">
                            <input type="text" class="form-control" placeholder="Search...">
                            <i class="fas fa-search position-absolute" style="right: 10px; top: 10px;"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                <li><a class="dropdown-item" href="#">New admission request</a></li>
                                <li><a class="dropdown-item" href="#">Counseling session reminder</a></li>
                                <li><a class="dropdown-item" href="#">Test results available</a></li>
                            </ul>
                        </div>
                        <div class="dropdown ms-3">
                            @if(Auth::check())
                            <button class="btn d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <div class="me-2 d-none d-sm-block">{{ Auth::user()->name }}</div>
                                <div class="avatar-xs bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user"></i>
                                </div>
                            </button>
                            @else
                            <button class="btn d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <div class="me-2 d-none d-sm-block">Guest</div>
                                <div class="avatar-xs bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user"></i>
                                </div>
                            </button>
                            @endif
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a href="{{ route('profile.student') }}" class="dropdown-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // Sidebar toggle
            $("#sidebarToggle").click(function() {
                $("#sidebar").toggleClass("collapsed");
                $("#content").toggleClass("expanded");
                if ($("#sidebar").hasClass("collapsed")) {
                    $("#sidebar-title").text("S");
                    $(".sidebar-user-name, .user-role").hide();
                    $(".avatar-circle").css({"width": "40px", "height": "40px", "font-size": "18px"});
                } else {
                    $("#sidebar-title").text("Student");
                    $(".sidebar-user-name, .user-role").show();
                    $(".avatar-circle").css({"width": "40px", "height": "40px", "font-size": "18px"});
                }
            });
            
            // Mobile sidebar toggle
            $("#mobileSidebarToggle").click(function() {
                $("#sidebar").toggleClass("show");
            });
            
            // Close sidebar when clicking outside on mobile
            $(document).click(function(event) {
                if (!$(event.target).closest('#sidebar, #mobileSidebarToggle').length) {
                    if ($(window).width() < 768 && $("#sidebar").hasClass("show")) {
                        $("#sidebar").removeClass("show");
                    }
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>