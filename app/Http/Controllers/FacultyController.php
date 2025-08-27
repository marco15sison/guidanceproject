<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('faculty');
    }

    /**
     * Show the faculty dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('faculty.dashboard');
    }

    /**
     * Show the faculty reports page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reports()
    {
        return view('faculty.reports');
    }

    /**
     * Show the faculty profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('profile.faculty');
    }

    /**
     * Show the student reports for a specific student.
     *
     * @param string $student_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function studentReports($student_id)
    {
        // In a real application, you would fetch the student and their reports from the database
        // For now, we'll just pass the student_id to the view
        return view('faculty.reports.student-reports', [
            'student_id' => $student_id
        ]);
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createReport()
    {
        return view('faculty.reports.create');
    }

    /**
     * Store a newly created report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReport(Request $request)
    {
        // Validate and store the report
        // Redirect to the reports page with success message
        return redirect()->route('faculty.reports')->with('success', 'Report created successfully.');
    }

    /**
     * Show the form for editing the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editReport($id)
    {
        return view('faculty.reports.edit', ['report_id' => $id]);
    }

    /**
     * Update the specified report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateReport(Request $request, $id)
    {
        // Validate and update the report
        // Redirect to the reports page with success message
        return redirect()->route('faculty.reports')->with('success', 'Report updated successfully.');
    }

    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showReport($id)
    {
        return view('faculty.reports.show', ['report_id' => $id]);
    }
}