<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Models\User;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Faculty\DashboardController as FacultyDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Debug routes
Route::get('/debug-auth-status', [LoginController::class, 'debugUserStatus'])
    ->middleware('auth')
    ->name('debug.auth.status');

Route::get('/debug-faculty-status', [LoginController::class, 'debugFacultyStatus'])
    ->middleware(['auth', 'admin']) // Assuming you have middleware to check for admin
    ->name('debug.faculty.status');

Route::get('/debug-student-status', [LoginController::class, 'debugStudentStatus'])
    ->middleware(['auth', 'admin']) // Assuming you have middleware to check for admin
    ->name('debug.student.status');

// Admin Routes
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/announcements', [AdminDashboardController::class, 'announcements'])->name('admin.announcements');
    Route::get('/announcements/create', [AdminDashboardController::class, 'createAnnouncement'])->name('admin.announcements.create');
    Route::get('/announcements/analytics', [AdminDashboardController::class, 'announcementAnalytics'])->name('admin.announcements.analytics');
    Route::get('/announcements/scheduled', [AdminDashboardController::class, 'scheduledAnnouncements'])->name('admin.announcements.scheduled');
    Route::get('/announcements/{id}/edit', [AdminDashboardController::class, 'editAnnouncement'])->name('admin.announcements.edit');
    Route::get('/announcement-categories', [AdminDashboardController::class, 'announcementCategories'])->name('admin.announcement-categories');
    Route::get('/announcement-categories/create', [AdminDashboardController::class, 'createAnnouncementCategory'])->name('admin.announcement-categories.create');

    // Add the debug route
    Route::get('/fix-announcement-data', [AdminDashboardController::class, 'fixAnnouncementData']);

    // Admin API routes for AJAX operations
    Route::prefix('api')->group(function () {
        // Announcement Categories API
        Route::get('/announcement-categories', [AdminDashboardController::class, 'getAnnouncementCategories']);
        Route::post('/announcement-categories', [AdminDashboardController::class, 'storeAnnouncementCategory']);
        Route::put('/announcement-categories/{id}', [AdminDashboardController::class, 'updateAnnouncementCategory']);
        Route::delete('/announcement-categories/{id}', [AdminDashboardController::class, 'deleteAnnouncementCategory']);
        
        // Announcements API - SPECIFIC ROUTES FIRST, THEN DYNAMIC ROUTES
        Route::get('/announcements/analytics', [AdminDashboardController::class, 'getAnnouncementAnalytics']);
        Route::get('/announcements/scheduled', [AdminDashboardController::class, 'getScheduledAnnouncements']);
        Route::post('/announcements/update-statuses', [AdminDashboardController::class, 'updateAnnouncementStatuses']);
        
        // Now the more generic routes
        Route::get('/announcements', [AdminDashboardController::class, 'getAnnouncements']);
        Route::post('/announcements', [AdminDashboardController::class, 'storeAnnouncement']);
        Route::get('/announcements/{id}', [AdminDashboardController::class, 'getAnnouncement']);
        Route::put('/announcements/{id}', [AdminDashboardController::class, 'updateAnnouncement']);
        Route::delete('/announcements/{id}', [AdminDashboardController::class, 'deleteAnnouncement']);
        
        // Attachments API
        Route::delete('/announcement-attachments/{id}', [AdminDashboardController::class, 'removeAttachment']);
    });
});

// Student/Public Routes for Announcements
Route::get('/announcements', [AdminDashboardController::class, 'index1'])->name('announcements.index');
Route::get('/announcements/{id}', [AdminDashboardController::class, 'show1'])->name('announcements.show');

// Public API routes
Route::prefix('api')->group(function () {
    Route::get('/announcements/public', [AdminDashboardController::class, 'getPublicAnnouncements']);
    Route::get('/announcements/public/{id}', [AdminDashboardController::class, 'getPublicAnnouncement']);
});

// Add this route temporarily to your web.php file
Route::get('/debug-announcements', function () {
    $allAnnouncements = \App\Models\Announcement::all();
    $activeAnnouncements = \App\Models\Announcement::where('status', 'active')->get();
    $categories = \App\Models\AnnouncementCategory::all();
    
    return [
        'total_announcements' => $allAnnouncements->count(),
        'active_announcements' => $activeAnnouncements->count(),
        'total_categories' => $categories->count(),
        'announcements' => $allAnnouncements->take(5)->toArray(),
        'categories' => $categories->take(5)->toArray()
    ];
});





// Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
//     Route::get('/information', [AdminDashboardController::class, 'information'])->name('admin.information');
// });


Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/inventory', [AdminDashboardController::class, 'inventory'])->name('admin.inventoryrecord');
    Route::get('/student/{id}', [AdminDashboardController::class, 'viewStudent'])->name('admin.student.view');
    Route::delete('/student/{id}', [AdminDashboardController::class, 'deleteStudent'])->name('admin.student.delete');
    
});

Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    
    // User management routes - add these new routes
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
    
    // User CRUD operations
    Route::post('/users/store', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/get/{user}', [AdminDashboardController::class, 'getUser'])->name('admin.users.get');
    Route::put('/users/update/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/delete/{user}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
});
 // Student appointments management
 Route::get('/appointments', [AdminDashboardController::class, 'appointment'])
 ->name('admin.appointments.student');
 
// View specific appointment details
Route::get('/appointments/{id}', [AdminDashboardController::class, 'show'])
 ->name('admin.appointments.show');
 
// Update appointment status (approve/reject)
Route::put('/appointments/{id}/status', [AdminDashboardController::class, 'updateStatus'])
 ->name('admin.appointments.status');
 
// Add notes to student appointment
Route::post('/appointments/{id}/notes', [AdminDashboardController::class, 'addNotes'])
 ->name('admin.appointments.notes');
 
// View student profile from appointment
Route::get('/student/{id}/profile', [AdminDashboardController::class, 'profile'])
 ->name('admin.student.profile');


 


// Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
//     Route::get('/counseling', [AdminDashboardController::class, 'counseling'])->name('admin.counseling');
// });
// Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
//     Route::get('/job-placement', [AdminDashboardController::class, 'jobplacement'])->name('admin.job-placement');
// });
// Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
//     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// });
 // Faculty Routes
 Route::prefix('faculty')->middleware(['auth', \App\Http\Middleware\FacultyMiddleware::class])->group(function () {
     Route::get('/dashboard', [FacultyDashboardController::class, 'index'])->name('faculty.dashboard');
 });

 Route::prefix('faculty')->middleware(['auth', \App\Http\Middleware\FacultyMiddleware::class])->group(function () {
    Route::get('/reports', [FacultyDashboardController::class, 'reports'])->name('faculty.reports');
});

Route::prefix('student')->middleware(['auth', \App\Http\Middleware\StudentMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');
    // In your routes/web.php file

    // Inventory Form
    Route::get('/inventory_form', [StudentDashboardController::class, 'inventory_form'])
        ->name('student.inventory_form');
    
    // Counselling Routes
    
    // Main counselling page
    Route::get('/councelling', [StudentDashboardController::class, 'counsel'])
        ->name('student.councelling'); // Route name needs to match what's used in views
    
    // View appointment history
    Route::get('/councelling/history', [StudentDashboardController::class, 'appointmentHistory'])
        ->name('student.history');
    
    // Book appointment
    Route::post('/councelling/appointment', [StudentDashboardController::class, 'bookAppointment'])
        ->name('student.book');
    
    // Check availability (add this AJAX endpoint)
    Route::get('/councelling/check-availability', [StudentDashboardController::class, 'checkAvailability'])
        ->name('student.check-availability');
    
    // Cancel appointment
    Route::put('/councelling/cancel/{id}', [StudentDashboardController::class, 'cancelAppointment'])
        ->name('student.cancel'); // Changed to match the form in views
    
    // Submit feedback
    Route::post('/councelling/feedback/{id}', [StudentDashboardController::class, 'submitFeedback'])
        ->name('student.feedback'); // Changed to match the form in views
    
    // View specific appointment
    Route::get('/councelling/appointment/{id}', [StudentDashboardController::class, 'viewAppointment'])
        ->name('student.appointmentview'); // Changed to match links in views
});






// Add this to your routes/web.php
Route::get('/test-logo', function() {
    $logoPath = public_path('images/psu_logo.png');
    if (file_exists($logoPath)) {
        return response()->file($logoPath);
    } else {
        return 'Logo file not found at: ' . $logoPath;
    }
});

// Inventory form routes
Route::post('/inventory', [InventoryController::class, 'store'])->name('student.store');
Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('student.show');
Route::get('/inventory/{id}/download', [InventoryController::class, 'downloadPdf'])->name('student.download');

// Check submission status routes
Route::get('/student/check/form', [InventoryController::class, 'checkForm'])->name('student.check.form');
Route::get('/student/check', [InventoryController::class, 'checkSubmission'])->name('student.check');

Route::middleware(['auth'])->group(function () {
    // Add the missing profile.index route
    
    Route::get('/profile/faculty', [ProfileController::class, 'showFacultyProfile'])->name('profile.faculty');
    Route::get('/profile/student', [ProfileController::class, 'showStudentProfile'])->name('profile.student');
    Route::get('/profile/admin', [ProfileController::class, 'showAdminProfile'])->name('profile.admin');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
// Redirect based on user role
Route::get('/home', function() {
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->user_type === 'faculty') {
            return redirect()->route('faculty.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }
    
    return redirect()->route('login');
})->name('home');