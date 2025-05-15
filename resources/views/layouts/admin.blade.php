<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Guidance Services</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
    --yellow-color: #f3ac12;     /* Vibrant yellow */
    --blue-color: #1a3c61;       /* Deep blue */
    --accent-color: #4d8bc9;     /* Light blue accent */
    --light-accent: #e9f0f9;     /* Very light blue */
    --hover-color: rgba(243, 172, 18, 0.85); /* Semi-transparent yellow for hover */
    --active-color: rgba(77, 139, 201, 0.9); /* Semi-transparent accent for active */
    --sidebar-width: 250px;
    --sidebar-collapsed-width: 70px;
    --transition-speed: 0.3s;
}

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f5f7fa;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Modern Sidebar with Gradient */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    background: linear-gradient(135deg, var(--yellow-color) 0%, var(--yellow-color) 25%, 
                var(--blue-color) 100%);
    color: white;
    transition: all var(--transition-speed);
    box-shadow: 3px 0 15px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    width: var(--sidebar-width);
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar.collapsed {
    width: var(--sidebar-collapsed-width);
}

/* Stylish Header with Subtle Depth */
.sidebar-header {
    padding: 20px 15px;
    background-color: rgba(0, 0, 0, 0.12);
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 2;
}

.sidebar-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0;
    letter-spacing: 0.5px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

/* Enhanced User Info Section */
.user-info {
    display: flex;
    align-items: center;
    padding: 18px 15px;
    background-color: rgba(0, 0, 0, 0.08);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: all var(--transition-speed);
}

.user-avatar {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all var(--transition-speed);
}

.user-role {
    font-size: 0.8rem;
    opacity: 0.8;
    font-weight: 500;
}

.avatar-circle {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all var(--transition-speed);
    background-color: rgba(0, 0, 0, 0.2) !important;
}

.sidebar-user-name {
    font-weight: 600;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Improved Navigation Links */
.sidebar .nav {
    margin-top: 10px;
    padding-bottom: 20px;
}

.sidebar .nav-item {
    margin: 4px 0;
}

.sidebar .nav-link {
    color: rgba(255, 255, 255, 0.9);
    padding: 14px 20px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    border-radius: 0 30px 30px 0;
    margin-right: 15px;
    border-left: 4px solid transparent;
    font-weight: 500;
    position: relative;
    z-index: 1;
}

.sidebar .nav-link:hover {
    color: white;
    background-color: var(--hover-color);
    border-left: 4px solid white;
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background-color: var(--active-color);
    color: white;
    border-left: 4px solid var(--yellow-color);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.sidebar .nav-link i {
    margin-right: 10px;
    width: 22px;
    text-align: center;
    font-size: 1.1rem;
    transition: all var(--transition-speed);
}

.sidebar.collapsed .nav-link span {
    display: none;
}

.sidebar.collapsed .nav-link {
    border-radius: 0;
    margin-right: 0;
    padding: 14px 0;
    justify-content: center;
}

.sidebar.collapsed .nav-link i {
    margin-right: 0;
    font-size: 1.3rem;
}

/* Hover effect enhancement */
.sidebar .nav-link::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0);
    z-index: -1;
    transition: all 0.2s;
    border-radius: 0 30px 30px 0;
}

.sidebar .nav-link:hover::after {
    background-color: rgba(255, 255, 255, 0.05);
}

/* Content Wrapper */
.content-wrapper {
    margin-left: var(--sidebar-width);
    transition: all var(--transition-speed);
    width: calc(100% - var(--sidebar-width));
}

.content-wrapper.expanded {
    margin-left: var(--sidebar-collapsed-width);
    width: calc(100% - var(--sidebar-collapsed-width));
}

/* Responsive Styles */
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

/* Added Animations for Better UX */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.nav-item {
    animation: fadeIn 0.5s ease-out;
}

.nav-item:nth-child(1) { animation-delay: 0.05s; }
.nav-item:nth-child(2) { animation-delay: 0.1s; }
.nav-item:nth-child(3) { animation-delay: 0.15s; }
.nav-item:nth-child(4) { animation-delay: 0.2s; }
.nav-item:nth-child(5) { animation-delay: 0.25s; }

/* Collapsed Sidebar Enhanced */
.sidebar.collapsed .user-info {
    justify-content: center;
    padding: 15px 5px;
}

.sidebar.collapsed .sidebar-user-name,
.sidebar.collapsed .user-role {
    display: none;
}

.sidebar.collapsed .user-avatar {
    margin-right: 0;
}

/* Toggle Button Enhanced */
#sidebarToggle {
    transition: all 0.3s;
}

#sidebarToggle:hover {
    transform: rotate(180deg);
}

.sidebar.collapsed #sidebarToggle {
    transform: rotate(180deg);
}
    </style>
    @yield('custom_styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <h5 id="sidebar-title" class="sidebar-title mb-0">Guidance Admin</h5>
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
                            <div class="avatar-circle rounded-circle bg-primary text-white">
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.inventoryrecord') }}" class="nav-link @if(request()->routeIs('admin.inventory*')) active @endif">
                        <i class="fas fa-boxes"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.announcements') }}" class="nav-link @if(request()->routeIs('admin.announcements*')) active @endif">
                        <i class="fas fa-info-circle"></i>
                        <span>Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.appointments.student') }}" class="nav-link @if(request()->routeIs('admin.appointments.student*')) active @endif">
                        <i class="fas fa-comments"></i>
                        <span>Counseling</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings') }}" class="nav-link @if(request()->routeIs('admin.settings*')) active @endif">
                        <i class="fas fa-comments"></i>
                        <span>Settings</span>
                    </a>
                </li>
            
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
                                    <a href="{{ route('profile.admin') }}" class="dropdown-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
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
                    $("#sidebar-title").text("GA");
                    $(".sidebar-user-name, .user-role").hide();
                    $(".avatar-circle").css({"width": "40px", "height": "40px", "font-size": "18px"});
                } else {
                    $("#sidebar-title").text("Guidance Admin");
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