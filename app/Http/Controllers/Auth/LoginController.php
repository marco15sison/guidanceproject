<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Add this import
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Log when login form is accessed
        Log::info('Login form accessed', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        
        return view('auth.login');
    }

    /**
     * Handle the login request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Log login attempt with basic info
        Log::info('Login attempt initiated', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Check if user exists and get status before authentication
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user) {
            // Log user details before authentication attempt
            Log::debug('User found before authentication', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'is_active' => $user->is_active,
                'is_active_type' => gettype($user->is_active)
            ]);
            
            // Check for inactive accounts
            if (!$user->is_active) {
                Log::warning('Inactive user attempting to log in', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'user_type' => $user->user_type
                ]);
                
                // Uncomment to block inactive users from logging in
                // return back()->withErrors([
                //     'login_error' => 'Your account is inactive. Please contact administrator.',
                // ])->withInput($request->except('password'));
            }
        } else {
            Log::warning('Login attempt with unknown user', [
                'email' => $credentials['email'],
                'ip' => $request->ip()
            ]);
        }

        // Debug modified credentials before authentication
        Log::debug('Authentication credentials', [
            'email' => $credentials['email'],
            'has_password' => !empty($credentials['password']),
            // Uncomment to add active check to credentials
            // 'requires_active' => true
        ]);

        // To enforce active status, modify the authentication attempt:
        // if (Auth::attempt($credentials + ['is_active' => true])) {
        
        // Standard authentication attempt
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Store login time for debugging
            session(['login_time' => now()->toDateTimeString()]);
            
            // Get current authenticated user
            $authenticatedUser = Auth::user();
            
            // Log successful login
            Log::info('User login successful', [
                'user_id' => $authenticatedUser->id,
                'email' => $authenticatedUser->email,
                'user_type' => $authenticatedUser->user_type,
                'is_active' => $authenticatedUser->is_active,
                'is_active_type' => gettype($authenticatedUser->is_active)
            ]);
            
            // Get user type to redirect accordingly
            $userType = $authenticatedUser->user_type;
            
            // Extra warning if inactive user somehow gets authenticated
            if (!$authenticatedUser->is_active) {
                Log::warning('Inactive user successfully authenticated', [
                    'user_id' => $authenticatedUser->id,
                    'email' => $authenticatedUser->email,
                    'user_type' => $userType
                ]);
            }
            
            // Log the redirection based on user type
            Log::debug('Redirecting authenticated user', [
                'user_type' => $userType,
                'user_id' => $authenticatedUser->id
            ]);
            
            if ($userType === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($userType === 'faculty') {
                return redirect()->route('faculty.dashboard');
            } elseif ($userType === 'student') {
                return redirect()->route('student.dashboard');
            }
            
            // Default redirect if user type is not recognized
            Log::warning('Unrecognized user type, using default redirect', [
                'user_type' => $userType,
                'user_id' => $authenticatedUser->id
            ]);
            
            return redirect()->intended('/dashboard');
        }
        
        // Log failed authentication
        Log::warning('Authentication failed', [
            'email' => $credentials['email'],
            'ip' => $request->ip()
        ]);

        // Authentication failed - display the error message
        return back()->withErrors([
            'login_error' => 'Your user or password is incorrect.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log the user out and destroy session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Get user details before logout for logging
        $user = Auth::user();
        
        if ($user) {
            Log::info('User logging out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'is_active' => $user->is_active,
                'session_id' => session()->getId()
            ]);
        } else {
            Log::warning('Logout attempted with no authenticated user');
        }
        
        // Logout the user
        Auth::logout();
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate the CSRF token
        $request->session()->regenerateToken();
        
        Log::info('User logged out successfully', [
            'session_id' => session()->getId(),
            'ip' => $request->ip()
        ]);
        
        // Redirect to login page with success message
        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
    
    /**
     * Debug user authentication status and type
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function debugUserStatus(Request $request)
    {
        // Check if there's a currently authenticated user
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get fresh user details from database
            $freshUser = User::find($user->id);
            
            // Log detailed user information
            Log::debug('Debug user status requested', [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'user_type' => $user->user_type,
                'is_active' => $user->is_active,
                'is_active_type' => gettype($user->is_active),
                'db_is_active' => $freshUser->is_active,
                'db_is_active_type' => gettype($freshUser->is_active),
                'strictly_active' => $user->is_active === true,
                'session_id' => session()->getId(),
                'remember_token' => $user->remember_token ? 'present' : 'not present',
                'login_time' => session('login_time', 'not set'),
                'last_activity' => session('last_activity', 'not set')
            ]);
            
            // Get database column type information
            $columnInfo = DB::select("SHOW COLUMNS FROM users WHERE Field = 'is_active'");
            
            return response()->json([
                'authenticated' => true,
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'user_type' => $user->user_type,
                'is_active' => $user->is_active,
                'is_active_type' => gettype($user->is_active),
                'db_is_active' => $freshUser->is_active,
                'db_is_active_type' => gettype($freshUser->is_active),
                'strictly_active' => $user->is_active === true,
                'db_column_info' => $columnInfo
            ]);
        } else {
            Log::debug('Debug user status requested - no authenticated user');
            return response()->json([
                'authenticated' => false
            ]);
        }
    }
    
    /**
     * Debug faculty user status specifically
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function debugFacultyStatus()
    {
        $facultyUsers = User::where('user_type', 'faculty')->get();
        $results = [];
        
        Log::debug('Faculty status debug requested', [
            'total_count' => $facultyUsers->count()
        ]);
        
        foreach ($facultyUsers as $user) {
            $results[] = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'is_active' => $user->is_active,
                'is_active_type' => gettype($user->is_active),
                'created_at' => $user->created_at
            ];
        }
        
        return response()->json([
            'faculty_count' => count($results),
            'faculty_users' => $results
        ]);
    }
    
    /**
     * Debug student user status specifically
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function debugStudentStatus()
    {
        $studentUsers = User::where('user_type', 'student')->get();
        $results = [];
        
        Log::debug('Student status debug requested', [
            'total_count' => $studentUsers->count()
        ]);
        
        foreach ($studentUsers as $user) {
            $results[] = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'is_active' => $user->is_active,
                'is_active_type' => gettype($user->is_active),
                'created_at' => $user->created_at
            ];
        }
        
        return response()->json([
            'student_count' => count($results),
            'student_users' => $results
        ]);
    }
}