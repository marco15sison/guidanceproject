<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Counsellor;
use App\Models\AppointmentFeedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('student.dashboard', compact('user'));
    }

    public function inventory_form()
    {
        $user = Auth::user();
        return view('student.inventory_form', compact('user'));
    }
    /**
     * Display the counselling services page.
     * Only NOIME CARLOS can be counsellor.
     *
     * @return \Illuminate\View\View
     */
    public function counsel(): View
    {
        // Get only NOIME CARLOS as counsellor
        $counsellors = Counsellor::noimeCarlos()
            ->active()
            ->get();
        
        $appointments = Appointment::with('counsellor')
            ->where('student_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed', 'rescheduled', 'in_progress'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->limit(3)
            ->get();
            
        return view('student.councelling', compact('counsellors', 'appointments'));
    }
    
    /**
     * Book a new counselling appointment.
     * Only NOIME CARLOS can be counsellor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bookAppointment(Request $request): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'counsellor_id' => 'required',
            'service_type' => 'required|in:academic,career,personal',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required',
            'reason' => 'required|string|max:500',
            'confidentiality' => 'required|accepted',
        ]);
        
        // Get the counsellor ID (handle static IDs)
        $counsellorId = $this->getCounsellorId($request->counsellor_id);
        
        // Verify the counsellor is NOIME CARLOS and is active
        $counsellor = Counsellor::noimeCarlos()
            ->active()
            ->find($counsellorId);
            
        if (!$counsellor) {
            return redirect()->back()->with('error', 'Invalid counsellor selected. Only NOIME CARLOS is available for counselling.');
        }
        
        // Check availability
        $isTimeSlotAvailable = $this->checkTimeSlotAvailability(
            $counsellorId,
            $request->preferred_date,
            $request->preferred_time
        );
        
        if (!$isTimeSlotAvailable) {
            return redirect()->back()->with('error', 'The selected time slot is no longer available. Please choose another time.');
        }
        
        try {
            // Create the appointment
            $appointment = new Appointment();
            $appointment->student_id = Auth::id();
            $appointment->counsellor_id = $counsellorId;
            $appointment->service_type = $request->service_type;
            $appointment->appointment_date = $request->preferred_date;
            $appointment->appointment_time = $request->preferred_time;
            $appointment->reason = $request->reason;
            $appointment->status = 'pending';
            $appointment->save();
            
            return redirect()->back()->with('success', 'Appointment request submitted successfully. You will be notified once it is confirmed.');
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->error('Failed to create appointment: ' . $e->getMessage());
            
            // Return with a user-friendly error message
            return redirect()->back()->with('error', 'There was a problem creating your appointment. Please try again later.');
        }
    }
    
    /**
     * Get the correct counsellor ID, handling static IDs.
     * 
     * @param mixed $counsellorId
     * @return int
     */
    private function getCounsellorId($counsellorId): int
    {
        $staticIds = ['1', '2', '3', '4', 'static-1', 'static-2', 'static-3', 'static-4'];
        
        // If it's a static ID, map it to the correct counsellor
        if (in_array($counsellorId, $staticIds)) {
            $staticIdMap = [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                'static-1' => 1,
                'static-2' => 2,
                'static-3' => 3,
                'static-4' => 4,
            ];
            
            return $staticIdMap[$counsellorId] ?? 1;
        }
        
        // Otherwise convert to integer
        return (int) $counsellorId;
    }
    
    /**
     * Check time slot availability.
     * Only NOIME CARLOS can be counsellor.
     *
     * @param  int  $counsellorId
     * @param  string  $date
     * @param  string  $time
     * @return bool
     */
    private function checkTimeSlotAvailability($counsellorId, $date, $time): bool
    {
        // Check if there's an existing appointment at the same time slot
        $existingAppointment = Appointment::where('counsellor_id', $counsellorId)
            ->where('appointment_date', $date)
            ->where('appointment_time', $time)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress', 'rescheduled'])
            ->exists();
            
        if ($existingAppointment) {
            return false;
        }
        
        // Get the counsellor and verify it's NOIME CARLOS
        $counsellor = Counsellor::noimeCarlos()
            ->find($counsellorId);
        
        if (!$counsellor) {
            return false;
        }
        
        // Check if counsellor is available on this day
        $dayOfWeek = Carbon::parse($date)->format('l');
        $availableDays = explode(',', strtolower($counsellor->available_days));
        
        if (!in_array(strtolower($dayOfWeek), $availableDays)) {
            return false;
        }
        
        // For simplicity, we're assuming the time is within the counsellor's available hours
        return true;
    }
    
    /**
     * Check availability for a specific date and counsellor.
     * Only NOIME CARLOS can be counsellor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'counsellor_id' => 'required',
            'date' => 'required|date',
        ]);
        
        $counsellorId = $this->getCounsellorId($request->counsellor_id);
        $date = $request->date;
        
        // Get the counsellor and verify it's NOIME CARLOS and is active
        $counsellor = Counsellor::noimeCarlos()
            ->active()
            ->find($counsellorId);
        
        if (!$counsellor) {
            return response()->json([
                'available_slots' => [], 
                'error' => 'Only NOIME CARLOS is available for counselling'
            ]);
        }
        
        // Check if counsellor is available on this day
        $dayOfWeek = Carbon::parse($date)->format('l');
        $availableDays = explode(',', strtolower($counsellor->available_days));
        
        if (!in_array(strtolower($dayOfWeek), $availableDays)) {
            return response()->json([
                'available_slots' => [],
                'message' => 'MS. NOIME CARLOS is not available on ' . $dayOfWeek
            ]);
        }
        
        // Get existing appointments for this counsellor on this date
        $existingAppointments = Appointment::where('counsellor_id', $counsellorId)
            ->where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress', 'rescheduled'])
            ->pluck('appointment_time')
            ->toArray();
        
        // All possible time slots
        $allTimeSlots = [
            '09:00:00',
            '10:00:00',
            '11:00:00',
            '13:00:00',
            '14:00:00',
            '15:00:00',
            '16:00:00',
        ];
        
        // Get available time slots
        $availableSlots = array_diff($allTimeSlots, $existingAppointments);
        
        return response()->json([
            'available_slots' => array_values($availableSlots),
            'counsellor_name' => $counsellor->name
        ]);
    }
    
    /**
     * View all appointment history.
     *
     * @return \Illuminate\View\View
     */
    public function appointmentHistory(): View
    {
        $appointments = Appointment::with('counsellor')
            ->where('student_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);
            
        return view('student.history', compact('appointments'));
    }
    
    /**
     * View individual appointment details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function viewAppointment($id): View
    {
        $appointment = Appointment::with(['counsellor', 'feedback'])
            ->where('student_id', Auth::id())
            ->findOrFail($id);
            
        return view('student.appointmentview', compact('appointment'));
    }
    
    /**
     * Cancel an appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelAppointment(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);
        
        $appointment = Appointment::where('student_id', Auth::id())->findOrFail($id);
        
        // Check if the appointment can be cancelled
        if (!in_array($appointment->status, ['pending', 'confirmed', 'rescheduled'])) {
            return redirect()->back()->with('error', 'This appointment cannot be cancelled.');
        }
        
        try {
            // Cancel the appointment
            $appointment->status = 'cancelled';
            $appointment->cancellation_reason = $request->cancellation_reason;
            $appointment->cancelled_at = Carbon::now();
            $appointment->cancelled_by = Auth::id();
            $appointment->save();
            
            return redirect()->route('student.history')
                ->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->error('Failed to cancel appointment: ' . $e->getMessage());
            
            // Return with a user-friendly error message
            return redirect()->back()->with('error', 'There was a problem cancelling your appointment. Please try again later.');
        }
    }
    
    /**
     * Submit feedback for an appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitFeedback(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:500',
        ]);
        
        $appointment = Appointment::where('student_id', Auth::id())->findOrFail($id);
        
        // Check if the appointment is completed
        if ($appointment->status != 'completed') {
            return redirect()->back()->with('error', 'You can only provide feedback for completed appointments.');
        }
        
        // Check if feedback already exists
        $existingFeedback = AppointmentFeedback::where('appointment_id', $id)->exists();
        
        if ($existingFeedback) {
            return redirect()->back()->with('error', 'You have already submitted feedback for this appointment.');
        }
        
        try {
            // Create the feedback
            $feedback = new AppointmentFeedback();
            $feedback->appointment_id = $id;
            $feedback->rating = $request->rating;
            $feedback->comments = $request->comments;
            $feedback->submitted_by = Auth::id();
            $feedback->save();
            
            return redirect()->route('student.appointmentview', $id)
                ->with('success', 'Feedback submitted successfully. Thank you for your input!');
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->error('Failed to submit feedback: ' . $e->getMessage());
            
            // Return with a user-friendly error message
            return redirect()->back()->with('error', 'There was a problem submitting your feedback. Please try again later.');
        }
    }
}

    