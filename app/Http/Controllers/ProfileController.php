<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the faculty profile view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showFacultyProfile()
    {
        $user = Auth::user();
        return view('profile.faculty', compact('user'));
    }

    /**
     * Show the student profile view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showStudentProfile()
    {
        $user = Auth::user();
        return view('profile.student', compact('user'));
    }

    /**
     * Show the admin profile view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAdminProfile()
    {
        $user = Auth::user();
        return view('profile.admin', compact('user'));
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('new_password')) {
            if (!(Hash::check($request->current_password, $user->password))) {
                return back()->with('error', 'Current password does not match');
            }
            
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        return back()->with('success', 'Profile updated successfully');
    }
}