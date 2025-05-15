<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\AppointmentNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Models\AnnouncementAttachment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get total students count
        $totalStudents = $this->getTotalStudents();
        
        // Calculate student growth percentage
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        $studentsThisMonth = User::where('user_type', 'student')
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();
            
        $studentsLastMonth = User::where('user_type', 'student')
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();
            
        $studentGrowth = $studentsLastMonth > 0 
            ? round((($studentsThisMonth - $studentsLastMonth) / $studentsLastMonth) * 100, 1) 
            : 0;
        
        // Add any other data you need for your dashboard
        
        return view('admin.dashboard', compact(
            'totalStudents',
            'studentGrowth'
        ));
    }
    
    /**
     * Get total number of students (users with student user_type)
     *
     * @return int
     */
    protected function getTotalStudents(): int
    {
        return User::where('user_type', 'student')->count();
    }
    
    // public function information()
    // {
    //     // You can add any data needed for the information page
    //     return view('admin.information');
    // }

    /**
     * Display student inventory records with filtering and analytics
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function inventory(Request $request)
{
    // Initialize query
    $query = Inventory::query();
    
    // Apply search if provided
    if ($request->has('search') && !empty($request->search)) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('full_name', 'like', "%{$searchTerm}%")
              ->orWhere('student_number', 'like', "%{$searchTerm}%")
              ->orWhere('course', 'like', "%{$searchTerm}%")
              ->orWhere('form_id', 'like', "%{$searchTerm}%");
        });
    }
    
    // Apply course filter if provided
    if ($request->has('course') && !empty($request->course)) {
        $query->where('course', $request->course);
    }
    
    // Apply year level filter if provided
    if ($request->has('year_level') && !empty($request->year_level)) {
        $query->where('year_level', $request->year_level);
    }
    
    // Handle Excel export if requested
    if ($request->has('export') && $request->export == 'excel') {
        return $this->exportInventoryToExcel($query);
    }
    
    // Get paginated results - exactly 10 per page
    $inventories = $query->orderBy('created_at', 'desc')->paginate(10);
    
    // Ensure filters are preserved when paginating
    $inventories->appends($request->except('page'));
    
    // Get analytics data
    $totalStudents = Inventory::count();
    $newStudents = Inventory::where('created_at', '>=', now()->subDays(7))->count();
    $maleCount = Inventory::where('gender', 'Male')->count();
    $femaleCount = Inventory::where('gender', 'Female')->count();
    
    // Get recent submissions
    $recentInventories = Inventory::orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
    // Get course and year level data for charts
    list($courseLabels, $courseData) = $this->getCourseDistributionData();
    list($yearLabels, $yearData) = $this->getYearLevelDistributionData();
    
    return view('admin.inventoryrecord', compact(
        'inventories',
        'totalStudents',
        'newStudents',
        'maleCount',
        'femaleCount',
        'courseLabels',
        'courseData',
        'yearLabels',
        'yearData',
        'recentInventories'
    ));
}

    /**
     * Get course distribution data for charts
     * 
     * @return array
     */
    private function getCourseDistributionData()
    {
        // Get course distribution data
        $courseDistribution = Inventory::select('course', DB::raw('count(*) as total'))
            ->groupBy('course')
            ->orderBy('total', 'desc')
            ->get();
        
        // If we have too many courses, keep only the top 5 and group others
        if ($courseDistribution->count() > 5) {
            $topCourses = $courseDistribution->take(5);
            $otherTotal = $courseDistribution->skip(5)->sum('total');
            
            if ($otherTotal > 0) {
                // Add "Other Courses" category
                $otherCourse = (object)[
                    'course' => 'Other Courses',
                    'total' => $otherTotal
                ];
                
                $topCourses->push($otherCourse);
            }
            
            $courseDistribution = $topCourses;
        }
        
        // Extract labels and data for the chart
        $courseLabels = $courseDistribution->pluck('course')->toArray();
        $courseData = $courseDistribution->pluck('total')->toArray();
        
        return [$courseLabels, $courseData];
    }

    /**
     * Get year level distribution data for charts
     * 
     * @return array
     */
    private function getYearLevelDistributionData()
    {
        // Standard year levels
        $standardYearLevels = ['First Year', 'Second Year', 'Third Year', 'Fourth Year', 'Fifth Year'];
        $yearData = [];
        
        // Get year level distribution from database
        $yearDistribution = Inventory::select('year_level', DB::raw('count(*) as total'))
            ->groupBy('year_level')
            ->orderByRaw("CASE 
                WHEN year_level = 'First Year' THEN 1
                WHEN year_level = 'Second Year' THEN 2
                WHEN year_level = 'Third Year' THEN 3
                WHEN year_level = 'Fourth Year' THEN 4
                WHEN year_level = 'Fifth Year' THEN 5
                ELSE 6 END")
            ->get();
        
        // Use database values if available, otherwise use standard year levels
        if ($yearDistribution->isNotEmpty()) {
            $yearLabels = $yearDistribution->pluck('year_level')->toArray();
            $yearData = $yearDistribution->pluck('total')->toArray();
        } else {
            $yearLabels = $standardYearLevels;
            foreach ($standardYearLevels as $year) {
                $yearData[] = Inventory::where('year_level', $year)->count();
            }
        }
        
        return [$yearLabels, $yearData];
    }
    

    public function appointment()
    {
        $appointments = Appointment::with(['student', 'counsellor'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
            
        return view('admin.appointments.student', compact('appointments'));
    }
    
    // View specific appointment
    public function show($id)
    {
        $appointment = Appointment::with(['student', 'counsellor', 'notes'])
            ->findOrFail($id);
        
        // Check if all relationships are loaded
        if (!$appointment->counsellor) {
            // Log this for debugging
            Log::warning("Appointment ID {$id} has no counsellor assigned");
        }
        
        return view('admin.appointments.show', compact('appointment'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,rejected,cancelled',
            'admin_notes' => 'nullable|string|max:500',
        ]);
        
        $appointment = Appointment::findOrFail($id);
        $oldStatus = $appointment->status;
        $appointment->status = $request->status; // This should now work because status is VARCHAR
        $appointment->save();
        
        // Add a note about the status change
        if ($request->filled('admin_notes')) {
            $note = new AppointmentNote();
            $note->appointment_id = $appointment->id;
            $note->admin_id = Auth::id();
            $note->note = $request->admin_notes;
            $note->save();
        }
        
        return redirect()->route('admin.appointments.show', $id)
            ->with('success', "Appointment status updated from {$oldStatus} to {$request->status}");
    }
    
    // View student profile
    public function profile($id)
    {
        $student = User::where('user_type', 'student')->findOrFail($id);
        
        $appointmentsHistory = Appointment::where('student_id', $student->id)
            ->with('counsellor')
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        // Check if any appointments have missing counsellors
        $missingCounsellors = $appointmentsHistory->filter(function($appt) {
            return is_null($appt->counsellor);
        })->count();
        
        if ($missingCounsellors > 0) {
            Log::warning("Student ID {$id} has {$missingCounsellors} appointments with no counsellor assigned");
        }
        
        return view('admin.student.profile', compact('student', 'appointmentsHistory'));
    }

    /**
     * View student inventory details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function viewStudent($id)
    {
        $inventory = Inventory::findOrFail($id);
        
        // Convert string data back to arrays for display
        $arrayFields = ['staying_place', 'finances', 'academic_health', 'psych_consultation'];
        $data = $inventory->toArray();
        
        foreach ($arrayFields as $field) {
            if (isset($data[$field]) && !is_array($data[$field]) && !empty($data[$field])) {
                $data[$field] = explode(', ', $data[$field]);
            }
        }
        
        return view('admin.student-view', compact('inventory', 'data'));
    }

    /**
     * Delete student inventory record
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteStudent($id)
    {
        $inventory = Inventory::findOrFail($id);
        $name = $inventory->full_name;
        
        // Delete photo if exists
        if ($inventory->photo && Storage::disk('public')->exists($inventory->photo)) {
            Storage::disk('public')->delete($inventory->photo);
        }
        
        $inventory->delete();
        
        return redirect()->route('admin.inventoryrecord')
            ->with('success', "Student inventory record for $name has been deleted.");
    }

    /**
 * Show the system settings page
 *
 * @return \Illuminate\View\View
 */
/**
     * Display the settings page with user management
     *
     * @return \Illuminate\View\View
     */
    public function settings(Request $request)
{
    Log::info('Settings page accessed by user: ' . Auth::id());
    
    // Get the status filter from request
    $statusFilter = $request->input('status');
    
    // Start building the query
    $query = User::where('user_type', '!=', 'admin');
    
    // Apply status filter if provided
    if ($statusFilter === 'active') {
        $query->where('is_active', true);
    } elseif ($statusFilter === 'inactive') {
        $query->where('is_active', false);
    }
    
    // Get users with ordering
    $users = $query->orderBy('user_type')
                  ->orderBy('name')
                  ->get();
    
    return view('admin.settings', compact('users', 'statusFilter'));
}

    /**
 * Store a newly created user (faculty or student only)
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function storeUser(Request $request) {
    // Log request data without sensitive info
    Log::info('storeUser method called with data:', $request->except(['password', 'password_confirmation']));
    
    // Debug raw is_active value before conversion
    Log::debug('is_active raw value:', [
        'value' => $request->input('is_active'),
        'type' => gettype($request->input('is_active')),
        'isset' => $request->has('is_active')
    ]);
    
    // Convert is_active to boolean, with default true to match migration default
    $isActive = true; // Default to true to match schema default
    if ($request->has('is_active')) {
        $isActive = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
    }
    $request->merge(['is_active' => $isActive]);
    
    // Debug is_active after conversion
    Log::debug('storeUser is_active debug:', [
        'raw_value' => $request->input('is_active'),
        'converted_value' => $request->is_active,
        'type' => gettype($request->is_active),
        'is_true' => $request->is_active === true,
        'is_false' => $request->is_active === false
    ]);
    
    // Validate with custom rule for ID format
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required', 
            'string',
            'max:255',
            'unique:users',
            function ($attribute, $value, $fail) use ($request) {
                $pattern = match ($request->user_type) {
                    'faculty' => '/^FAC-[A-Z]{2}(-\d{4})?$/',  // FAC-SC or FAC-SC-0000 format
                    'student' => '/^\d{2}-[A-Z]{2}-\d{4}$/',   // 22-SC-0216 format
                    default => null,
                };
                
                if ($pattern && !preg_match($pattern, $value)) {
                    $fail('The ID format is invalid for the selected user type.');
                }
            },
        ],
        'email_address' => ['nullable', 'email'],
        'password' => ['required', 'confirmed', Password::defaults()],
        'user_type' => ['required', 'string', 'in:faculty,student'], // Admin removed
        'is_active' => ['boolean'], // Make it optional since we have a default
    ]);

    // Debug is_active after validation
    Log::debug('Final is_active value before saving:', [
        'value' => $request->is_active,
        'boolean_check' => is_bool($request->is_active),
        'strict_comparison' => $request->is_active === true ? 'true' : 'false'
    ]);

    try {
        // Create the user with proper boolean for is_active
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // Store ID in email field for login
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'is_active' => $request->is_active,
        ]);
        
        // Debug user active status after save
        Log::debug('User active status after save:', [
            'user_id' => $user->id,
            'is_active' => $user->is_active,
            'type' => gettype($user->is_active)
        ]);
        
        $userType = ucfirst($request->user_type); // Capitalize for message
        $activeStatus = $user->is_active ? 'active' : 'inactive';
        Log::info($userType . ' created successfully with ID: ' . $request->email . ' (Status: ' . $activeStatus . ')');
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('success', $userType . ' created successfully as ' . $activeStatus . '.');
    } catch (\Exception $e) {
        Log::error('Error creating user: ' . $e->getMessage());
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('error', 'Error creating user: ' . $e->getMessage());
    }
}

/**
 * Update a user (faculty or student only)
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\User  $user
 * @return \Illuminate\Http\RedirectResponse
 */
public function updateUser(Request $request, User $user)
{
    // Log update attempt
    Log::info('updateUser method called for user ID: ' . $user->id);
    Log::debug('Update data:', $request->except(['password', 'password_confirmation']));
    
    // Debug raw is_active value before conversion
    Log::debug('is_active raw value before conversion:', [
        'value' => $request->input('is_active'),
        'type' => gettype($request->input('is_active')),
        'isset' => $request->has('is_active')
    ]);
    
    // Prevent editing admin accounts
    if ($user->user_type === 'admin') {
        Log::warning('Attempted to update admin user (ID: ' . $user->id . ')');
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('error', 'Admin accounts cannot be modified through this interface.');
    }
    
    // Convert is_active field to proper boolean
    // If the field isn't in the request, don't change the current value
    if ($request->has('is_active')) {
        $isActive = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        $request->merge(['is_active' => $isActive]);
    }
    
    Log::debug('is_active value after conversion:', [
        'value' => $request->is_active, 
        'type' => gettype($request->is_active),
        'is_true' => $request->is_active === true,
        'is_false' => $request->is_active === false,
        'in_request' => $request->has('is_active')
    ]);
    
    $validationRules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required', 
            'string', 
            'max:255', 
            'unique:users,email,' . $user->id,
            function ($attribute, $value, $fail) use ($request) {
                $pattern = match ($request->user_type) {
                    'faculty' => '/^FAC-[A-Z]{2}(-\d{4})?$/',  // FAC-SC or FAC-SC-0000 format
                    'student' => '/^\d{2}-[A-Z]{2}-\d{4}$/',  // 22-SC-0216 format
                    default => null,
                };
                
                if ($pattern && !preg_match($pattern, $value)) {
                    $fail('The ID format is invalid for the selected user type.');
                }
            },
        ],
        'email_address' => ['nullable', 'email'],
        'password' => ['nullable', 'confirmed', Password::defaults()],
        'user_type' => ['required', 'string', 'in:faculty,student'], // Admin removed
    ];
    
    // Only validate is_active if it's in the request
    if ($request->has('is_active')) {
        $validationRules['is_active'] = ['boolean'];
    }
    
    $request->validate($validationRules);

    // Debug is_active after validation
    Log::debug('Final is_active value before saving:', [
        'value' => $request->is_active,
        'boolean_check' => $request->has('is_active') ? is_bool($request->is_active) : 'not in request',
        'strict_comparison' => $request->has('is_active') ? ($request->is_active === true ? 'true' : 'false') : 'not in request'
    ]);

    try {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'email_address' => $request->email_address,
        ];

        // Only update is_active if it's in the request
        if ($request->has('is_active')) {
            $data['is_active'] = $request->is_active;
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        Log::debug('User update data:', $data);
        $user->update($data);
        
        // Refresh the user model to get updated data
        $user = $user->fresh();
        
        // Debug user active status after update
        Log::debug('User active status after update:', [
            'user_id' => $user->id,
            'is_active' => $user->is_active,
            'type' => gettype($user->is_active)
        ]);
        
        $userType = ucfirst($user->user_type); // Capitalize for message
        $activeStatus = $user->is_active ? 'active' : 'inactive';
        Log::info($userType . ' updated successfully: ' . $user->id . ' (Status: ' . $activeStatus . ')');
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('success', $userType . ' updated successfully as ' . $activeStatus . '.');
    } catch (\Exception $e) {
        Log::error('Error updating user: ' . $e->getMessage());
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('error', 'Error updating user: ' . $e->getMessage());
    }
}

/**
 * Delete a user (faculty or student only)
 *
 * @param  \App\Models\User  $user
 * @return \Illuminate\Http\RedirectResponse
 */
public function deleteUser(User $user)
{
    Log::info('deleteUser method called for user ID: ' . $user->id);
    
    // Debug user status before deletion
    Log::debug('User status before deletion:', [
        'user_id' => $user->id,
        'user_type' => $user->user_type,
        'is_active' => $user->is_active,
        'status_type' => gettype($user->is_active)
    ]);
    
    // Prevent deleting admin accounts
    if ($user->user_type === 'admin') {
        Log::warning('Attempted to delete admin user (ID: ' . $user->id . ')');
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('error', 'Admin accounts cannot be deleted through this interface.');
    }
    
    try {
        $userType = ucfirst($user->user_type);
        $userName = $user->name;
        $activeStatus = $user->is_active ? 'active' : 'inactive';
        
        $user->delete();
        
        Log::info($userType . ' deleted: ' . $userName . ' (ID: ' . $user->id . ', Status was: ' . $activeStatus . ')');
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('success', $userType . ' deleted successfully.');
    } catch (\Exception $e) {
        Log::error('Error deleting user: ' . $e->getMessage());
        return redirect()->route('admin.settings', ['#user-management'])
            ->with('error', 'Error deleting user: ' . $e->getMessage());
    }
}


    /**
     * Show the announcements management page.
     */
    public function announcements()
    {
        $categories = AnnouncementCategory::withCount('announcements')->get();
        return view('admin.announcements', compact('categories'));
    }
    
    /**
     * Show the form for creating a new announcement.
     */
    public function createAnnouncement()
    {
        $categories = AnnouncementCategory::where('is_active', true)->get();
        return view('admin.announcements.create', compact('categories'));
    }
    
    /**
     * Show the form for editing an announcement.
     */
    public function editAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $categories = AnnouncementCategory::where('is_active', true)->get();
        return view('admin.announcements.edit', [
            'announcement' => $announcement,
            'categories' => $categories,
            'id' => $id
        ]);
    }

    
    
    /**
     * Display the announcements analytics page.
     */
    public function announcementAnalytics()
    {
        // Get categories with announcement counts
        $categories = AnnouncementCategory::withCount(['announcements' => function ($query) {
            $query->where('status', 'active');
        }])->get();
        
        // Get most viewed announcements
        $mostViewed = Announcement::with('category')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        
        // Get audience distribution
        $byAudience = Announcement::select('target_audience')
            ->selectRaw('count(*) as total')
            ->groupBy('target_audience')
            ->orderBy('total', 'desc')
            ->get();
            
        // Get announcement totals by status
        $totalActive = Announcement::where('status', 'active')->count();
        $totalScheduled = Announcement::where('status', 'scheduled')->count();
        $totalExpired = Announcement::where('status', 'expired')->count();
        $totalDrafts = Announcement::where('status', 'draft')->count();
        
        $totals = [
            'active' => $totalActive,
            'scheduled' => $totalScheduled,
            'expired' => $totalExpired,
            'drafts' => $totalDrafts
        ];
        
        return view('admin.announcements.analytics', [
            'categories' => $categories,
            'mostViewed' => $mostViewed,
            'byAudience' => $byAudience,
            'totals' => $totals
        ]);
    }
    
    /**
     * Display the scheduled announcements page.
     */
    public function scheduledAnnouncements(Request $request)
    {
        $days = $request->input('days', 7);
        $endDate = Carbon::now()->addDays($days);
        
        $scheduled = Announcement::with('category')
            ->where('status', 'scheduled')
            ->where('publish_date', '<=', $endDate)
            ->orderBy('publish_date')
            ->get();
            
        return view('admin.announcements.scheduled', [
            'scheduled' => $scheduled,
            'days' => $days
        ]);
    }
    
    /*
     * API Endpoints for Announcements
     */
    
    /**
     * Get all announcement categories for AJAX.
     */
    public function getAnnouncementCategories()
    {
        $categories = AnnouncementCategory::withCount('announcements')->get();
        return response()->json($categories);
    }
    
    /**
     * Store a new announcement category.
     */
    public function storeAnnouncementCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        $category = AnnouncementCategory::create($validated);
        return response()->json($category, 201);
    }
    
    /**
     * Update an announcement category.
     */
    public function updateAnnouncementCategory(Request $request, $id)
    {
        $category = AnnouncementCategory::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);
        return response()->json($category, 200);
    }
    
    /**
     * Delete an announcement category.
     */
    public function deleteAnnouncementCategory($id)
    {
        $category = AnnouncementCategory::findOrFail($id);
        
        // Check if category has announcements
        if ($category->announcements()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category with announcements'], 422);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
    


/**
 * Get list of announcements for AJAX.
 */
public function getAnnouncements(Request $request)
{
    try {
        // Debug log the request with more details
        Log::info('getAnnouncements request:', [
            'params' => $request->all(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'ip' => $request->ip()
        ]);
        
        // Query builder with eager loading of both category and attachments
        $query = Announcement::with(['category', 'attachments']);
        
        // Filter by category if specified
        if ($request->has('category_id') && !empty($request->category_id) && $request->category_id !== 'all') {
            $categoryId = $request->category_id;
            
            // Check if the category exists
            $categoryExists = AnnouncementCategory::where('id', $categoryId)->exists();
            if (!$categoryExists) {
                Log::warning("Requested category ID {$categoryId} does not exist in database");
                
                // Return an empty result set with proper pagination structure
                return response()->json([
                    'current_page' => 1,
                    'data' => [],
                    'from' => null,
                    'last_page' => 1,
                    'per_page' => 10,
                    'to' => null,
                    'total' => 0
                ]);
            }
            
            $query->where('category_id', $categoryId);
            Log::info("Filtering by category ID: {$categoryId}");
        } else {
            Log::info("No category filter applied - returning all announcements");
        }
        
        // Filter by status if specified
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
            Log::info("Filtering by status: {$request->status}");
        }
        
        // Sort by
        $sortBy = $request->input('sort_by', 'publish_date');
        $sortDir = $request->input('sort_dir', 'desc');
        
        // Validate sort fields to prevent SQL injection
        $allowedSortFields = ['id', 'title', 'publish_date', 'expiry_date', 'status', 'views', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSortFields)) {
            Log::warning("Invalid sort field requested: {$sortBy}. Using 'publish_date' instead.");
            $sortBy = 'publish_date';
        }
        
        $query->orderBy($sortBy, $sortDir);
        Log::info("Sorting by: {$sortBy} {$sortDir}");
        
        // Debug the SQL query
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        
        // For logging the SQL with proper bindings, we'll use a simpler approach
        Log::info('SQL query: ' . $sql);
        Log::info('SQL bindings: ' . json_encode($bindings));
        
        // Get total count before pagination for debugging
        $totalCount = $query->count();
        Log::info("Found {$totalCount} announcements before pagination");
        
        // If no announcements found at all, return proper empty paginated result
        if ($totalCount === 0) {
            Log::info("No announcements found matching criteria - returning empty result set");
            
            // Return standardized empty paginated result structure
            return response()->json([
                'current_page' => 1,
                'data' => [],
                'from' => null,
                'last_page' => 1,
                'per_page' => 10,
                'to' => null,
                'total' => 0
            ]);
        }
        
        // Get the requested page and verify it's valid
        $page = (int)$request->input('page', 1);
        $perPage = (int)$request->input('per_page', 10);
        
        // Calculate max page
        $maxPage = ceil($totalCount / $perPage);
        
        // Check if requested page is valid
        if ($page > $maxPage) {
            Log::warning("Requested page {$page} exceeds max page {$maxPage} - adjusting to max page");
            $page = $maxPage;
        }
        
        // Paginate results
        $announcements = $query->paginate($perPage, ['*'], 'page', $page);
        
        // Log detailed pagination info
        Log::info("Pagination results:", [
            'current_page' => $announcements->currentPage(),
            'total_pages' => $announcements->lastPage(),
            'items_per_page' => $announcements->perPage(),
            'total_items' => $announcements->total(),
            'items_in_current_page' => $announcements->count()
        ]);
        
        // Check if the paginated results actually contain data
        if ($announcements->isEmpty() && $totalCount > 0) {
            Log::warning("Pagination issue: Found {$totalCount} total records but returning empty page");
            
            // This shouldn't happen now that we're validating page numbers, but just in case
            $announcements = $query->paginate($perPage, ['*'], 'page', 1);
            Log::info("Fallback to page 1 with {$announcements->count()} items");
        }
        
        // Add debug info to the response headers
        return response()->json($announcements)
            ->header('X-Debug-Total', $totalCount)
            ->header('X-Debug-Page', $page)
            ->header('X-Debug-Per-Page', $perPage);
            
    } catch (\Exception $e) {
        Log::error('Error in getAnnouncements: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'error' => 'Failed to load announcements: ' . $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTraceAsString() : null
        ], 500);
    }
}

/**
 * Get a specific announcement.
 */
public function getAnnouncement(Request $request, $id)
{
    try {
        // Log the request
        Log::info("Loading announcement with ID: {$id}", [
            'request_url' => $request->fullUrl(),
            'is_public_view' => $request->has('public_view') && $request->public_view,
            'user_agent' => $request->userAgent()
        ]);
        
        // First check if the announcement exists without eager loading
        $exists = Announcement::where('id', $id)->exists();
        if (!$exists) {
            Log::warning("Announcement ID {$id} does not exist in database");
            return response()->json(['message' => 'Announcement not found'], 404);
        }
        
        // Now get with eager loading
        $announcement = Announcement::with(['category', 'attachments'])->findOrFail($id);
        
        // Verify the category exists
        if (!$announcement->category) {
            Log::warning("Announcement {$id} has category_id {$announcement->category_id} but category does not exist");
            
            // Try to fix the issue by setting it to the first available category
            $firstCategory = AnnouncementCategory::first();
            if ($firstCategory) {
                $announcement->category_id = $firstCategory->id;
                $announcement->save();
                
                Log::info("Fixed announcement {$id} by setting category_id to {$firstCategory->id}");
                
                // Reload to get the new category
                $announcement = Announcement::with(['category', 'attachments'])->findOrFail($id);
            }
        }
        
        // Log success
        Log::info("Successfully loaded announcement: {$announcement->title}", [
            'category' => $announcement->category ? $announcement->category->name : 'None',
            'attachments_count' => $announcement->attachments ? $announcement->attachments->count() : 0
        ]);
        
        // Increment view count if this is a public view
        if ($request->has('public_view') && $request->public_view) {
            $announcement->increment('views');
            Log::info("Incremented view count for announcement ID: {$id}");
        }
        
        return response()->json($announcement);
    } catch (ModelNotFoundException $e) {
        Log::warning("Announcement not found: {$id}");
        return response()->json(['message' => 'Announcement not found'], 404);
    } catch (\Exception $e) {
        Log::error("Error getting announcement {$id}: " . $e->getMessage());
        Log::error("Stack trace: " . $e->getTraceAsString());
        return response()->json(['message' => 'Failed to load announcement details'], 500);
    }
}
    
    /**
 * Store a new announcement.
 */
public function storeAnnouncement(Request $request)
{
    try {
        // Log the incoming request
        Log::info('Creating new announcement', [
            'request_data' => $request->except(['attachments']),
            'has_attachments' => $request->hasFile('attachments')
        ]);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:announcement_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|string|max:100',
            'publish_date' => 'required|date',
            'expiry_date' => 'required|date|after:publish_date',
            'is_featured' => 'boolean',
            'attachments.*' => 'nullable|file|max:10240' // 10MB max file size
        ]);
        
        // Log successful validation
        Log::info('Announcement validated successfully');
        
        // Check if the category exists and is active
        $category = AnnouncementCategory::find($validated['category_id']);
        if (!$category) {
            Log::warning("Category with ID {$validated['category_id']} not found");
            return response()->json(['error' => 'Selected category not found'], 422);
        }
        
        if (!$category->is_active) {
            Log::warning("Category with ID {$validated['category_id']} is inactive");
            // Still proceed, but log the warning
        }
        
        // Determine status based on publish date
        $now = Carbon::now();
        $publishDate = Carbon::parse($validated['publish_date']);
        
        if ($request->has('status')) {
            $status = $request->status;
            Log::info("Using explicit status: {$status}");
        } elseif ($now->lt($publishDate)) {
            $status = 'scheduled';
            Log::info("Setting status to 'scheduled' because publish date is in the future");
        } else {
            $status = 'active';
            Log::info("Setting status to 'active' because publish date is now or in the past");
        }
        
        // Create announcement
        $announcement = Announcement::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target_audience' => $validated['target_audience'],
            'publish_date' => $validated['publish_date'],
            'expiry_date' => $validated['expiry_date'],
            'status' => $status,
            'is_featured' => $request->input('is_featured', false),
        ]);
        
        Log::info("Created announcement with ID: {$announcement->id}", [
            'title' => $announcement->title,
            'category_id' => $announcement->category_id,
            'status' => $announcement->status
        ]);
        
        // Handle attachments
        $attachmentsCount = 0;
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $path = $file->store('announcements');
                    
                    AnnouncementAttachment::create([
                        'announcement_id' => $announcement->id,
                        'filename' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize()
                    ]);
                    
                    $attachmentsCount++;
                    Log::info("Added attachment for announcement {$announcement->id}: {$file->getClientOriginalName()}");
                } catch (\Exception $e) {
                    Log::error("Failed to store attachment: {$e->getMessage()}");
                    // Continue with other attachments even if one fails
                }
            }
        }
        
        Log::info("Announcement creation complete. Added {$attachmentsCount} attachments");
        
        // Reload with category and attachments for the response
        $announcement->load(['category', 'attachments']);
        
        return response()->json($announcement, 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning('Announcement validation failed', [
            'errors' => $e->errors()
        ]);
        throw $e; // Re-throw to let Laravel handle the validation response
    } catch (\Exception $e) {
        Log::error('Error creating announcement: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        
        return response()->json([
            'error' => 'Failed to create announcement: ' . $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Update an announcement.
     */
    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:announcement_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|string|max:100',
            'publish_date' => 'required|date',
            'expiry_date' => 'required|date|after:publish_date',
            'status' => 'nullable|in:draft,scheduled,active',
            'is_featured' => 'boolean',
            'attachments.*' => 'nullable|file|max:10240' // 10MB max file size
        ]);

        // Determine status based on dates if not explicitly set
        if (!$request->has('status')) {
            $now = Carbon::now();
            $publishDate = Carbon::parse($validated['publish_date']);
            
            if ($announcement->status === 'draft') {
                $status = 'draft';
            } elseif ($now->lt($publishDate)) {
                $status = 'scheduled';
            } else {
                $status = 'active';
            }
            
            $validated['status'] = $status;
        }

        $announcement->update($validated);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('announcements');
                
                AnnouncementAttachment::create([
                    'announcement_id' => $announcement->id,
                    'filename' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize()
                ]);
            }
        }

        return response()->json($announcement->load('attachments'), 200);
    }
    
    /**
     * Delete an announcement.
     */
    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Delete associated attachments
        foreach ($announcement->attachments as $attachment) {
            Storage::delete($attachment->filename);
            $attachment->delete();
        }
        
        $announcement->delete();
        
        return response()->json(['message' => 'Announcement deleted successfully'], 200);
    }
    
    /**
     * Remove an attachment.
     */
    public function removeAttachment($id)
    {
        $attachment = AnnouncementAttachment::findOrFail($id);
        
        Storage::delete($attachment->filename);
        $attachment->delete();
        
        return response()->json(['message' => 'Attachment removed successfully'], 200);
    }
    
    /**
     * Get announcements analytics data for AJAX.
     */
    public function getAnnouncementAnalytics()
    {
        $categories = AnnouncementCategory::withCount(['announcements' => function ($query) {
            $query->where('status', 'active');
        }])->get();
        
        $mostViewed = Announcement::orderBy('views', 'desc')->take(5)->get();
        
        $byAudience = Announcement::select('target_audience')
            ->selectRaw('count(*) as total')
            ->groupBy('target_audience')
            ->orderBy('total', 'desc')
            ->get();
            
        $totalActive = Announcement::where('status', 'active')->count();
        $totalScheduled = Announcement::where('status', 'scheduled')->count();
        $totalExpired = Announcement::where('status', 'expired')->count();
        $totalDrafts = Announcement::where('status', 'draft')->count();
        
        return response()->json([
            'categories' => $categories,
            'most_viewed' => $mostViewed,
            'by_audience' => $byAudience,
            'totals' => [
                'active' => $totalActive,
                'scheduled' => $totalScheduled,
                'expired' => $totalExpired,
                'drafts' => $totalDrafts
            ]
        ]);
    }
    
    /**
     * Get scheduled announcements for AJAX.
     */
    public function getScheduledAnnouncements(Request $request)
    {
        $days = $request->input('days', 7);
        $endDate = Carbon::now()->addDays($days);
        
        $scheduled = Announcement::where('status', 'scheduled')
            ->where('publish_date', '<=', $endDate)
            ->orderBy('publish_date')
            ->get();
            
        return response()->json($scheduled);
    }
    
    /**
 * Get public announcements for students.
 */
public function getPublicAnnouncements(Request $request)
{
    // Debug information
    Log::info('Public announcements request', [
        'request' => $request->all(),
        'url' => $request->fullUrl()
    ]);

    // TEMPORARY: Get ALL announcements without any filters
    $allAnnouncements = Announcement::with('category')->get();
    
    // Log the count
    Log::info('Total announcements in database: ' . $allAnnouncements->count());
    
    if ($allAnnouncements->count() == 0) {
        Log::warning('No announcements found in the database!');
        return response()->json([
            'data' => [],
            'total' => 0,
            'message' => 'No announcements found in the database. Please create some announcements first.'
        ]);
    }

    // Regular pagination structure
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $items = $allAnnouncements->forPage($page, $perPage);
    
    // Create a pagination-like response
    $result = new \Illuminate\Pagination\LengthAwarePaginator(
        $items, 
        $allAnnouncements->count(), 
        $perPage, 
        $page
    );

    return response()->json($result);
}
    
    /**
     * Get a public announcement for students.
     */
    public function getPublicAnnouncement($id)
    {
        $announcement = Announcement::with('category', 'attachments')->findOrFail($id);
        
        // Check if announcement is active and not expired
        if ($announcement->status !== 'active' || 
            $announcement->publish_date > now() || 
            $announcement->expiry_date < now()) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }
        
        // Increment view count
        $announcement->increment('views');
        
        return response()->json($announcement);
    }
    
    /**
     * Update announcement statuses based on dates.
     * This method can be called from the scheduler.
     */
    public function updateAnnouncementStatuses()
    {
        $now = Carbon::now();
        
        // Update scheduled announcements to active if publish date has passed
        $activated = Announcement::where('status', 'scheduled')
            ->where('publish_date', '<=', $now)
            ->update(['status' => 'active']);
            
        // Update active announcements to expired if expiry date has passed
        $expired = Announcement::where('status', 'active')
            ->where('expiry_date', '<', $now)
            ->update(['status' => 'expired']);
            
        return response()->json([
            'message' => "Updated announcement statuses: {$activated} activated, {$expired} expired."
        ]);
    }

    /**
 * Test route to verify announcement accessibility
 * 
 * @return \Illuminate\Http\JsonResponse
 */
public function testAnnouncements()
{
    // Check if we have any active announcements
    $activeCount = Announcement::where('status', 'active')->count();
    
    // Get a sample active announcement
    $sampleAnnouncement = Announcement::where('status', 'active')
        ->with('category')
        ->first();
    
    // Get routes that should be available
    $indexRoute = route('announcements.index');
    $showRoute = $sampleAnnouncement ? route('announcements.show', $sampleAnnouncement->id) : null;
    
    // Test API endpoints
    try {
        $apiResult = $this->getPublicAnnouncements(request());
        $apiSuccess = true;
        $apiResponse = json_decode($apiResult->getContent());
    } catch (\Exception $e) {
        $apiSuccess = false;
        $apiResponse = $e->getMessage();
    }
    
    return response()->json([
        'test_time' => now()->toDateTimeString(),
        'announcement_counts' => [
            'active' => $activeCount,
            'total' => Announcement::count()
        ],
        'sample_announcement' => $sampleAnnouncement,
        'routes' => [
            'index' => $indexRoute,
            'show' => $showRoute,
            'api' => '/api/announcements/public'
        ],
        'api_test' => [
            'success' => $apiSuccess,
            'response' => $apiResponse
        ]
    ]);
}

/**
 * Display a test announcement page
 *
 * @return \Illuminate\View\View
 */
public function testAnnouncementView()
{
    // Get a sample active announcement
    $announcement = Announcement::where('status', 'active')->first();
    
    if (!$announcement) {
        return view('announcements.test', [
            'error' => 'No active announcements found',
            'announcement' => null
        ]);
    }
    
    return view('announcements.test', [
        'announcement' => $announcement
    ]);
}

/**
     * Display the announcements index page for students.
     *
     * @return \Illuminate\View\View
     */
    public function index1()
    {
        return view('announcements.index');
    }
    
    /**
 * Display a single announcement for students.
 * 
 * @param int $id
 * @return \Illuminate\View\View
 */
public function show1($id)
{
    // Find the announcement with relationships
    $announcement = Announcement::with(['category', 'attachments'])
        ->find($id);
        
    // Log debugging information
    Log::info("Loading announcement with ID: {$id}", [
        'found' => $announcement ? 'yes' : 'no',
        'status' => $announcement->status ?? 'none',
        'current_date' => now()->toDateTimeString()
    ]);
    
    // Get related announcements if available
    $relatedAnnouncements = [];
    if ($announcement && $announcement->category_id) {
        $relatedAnnouncements = Announcement::with('category')
            ->where('id', '!=', $id)
            ->where('category_id', $announcement->category_id)
            ->where('status', 'active')
            ->take(3)
            ->get();
    }
    
    // Increment view count if announcement exists
    if ($announcement) {
        $announcement->increment('views');
    }
    
    return view('announcements.show', [
        'id' => $id,
        'announcement' => $announcement,
        'relatedAnnouncements' => $relatedAnnouncements
    ]);
}
}