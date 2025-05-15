<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Report;
use App\Models\StudentAcademicInfo;
use App\Models\Referral;
use App\Models\ReferralMessage;
use App\Models\ReferralStatus;
use App\Models\ReferralDocument;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('faculty.dashboard', compact('user'));
    }

    public function reports()
    {
        // You can add any data needed for the information page
        return view('faculty.reports');
    }
}