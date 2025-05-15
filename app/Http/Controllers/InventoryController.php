<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    /**
     * Display the inventory form
     */
    public function create()
    {
        return view('inventory.form');
    }

    /**
     * Validate inventory form data
     * 
     * @param Request $request
     * @return array
     */
    protected function validateInventoryForm(Request $request)
    {
        return $request->validate([
            // Required fields - only essential information
            'full_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'civil_status' => 'required|string|max:50',
            'staying_place' => 'required|array',
            'high_school_type' => 'required|string|max:50',
            
            // Optional personal information
            'student_number' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048', // 2MB limit
            'place_of_birth' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:15|max:99',
            'religion' => 'nullable|string|max:100',
            'citizenship' => 'nullable|string|max:100',
            'contact_number' => 'nullable|string|max:20',
            'residential_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            
            // Educational background
            'high_school_name' => 'nullable|string|max:255',
            'previous_school_address' => 'nullable|string|max:255',
            'year_graduated' => 'nullable|string|max:4',
            'high_school_gpa' => 'nullable|string|max:10',
            'awards' => 'nullable|string|max:500',
            'previous_college_name' => 'nullable|string|max:255',
            
            // Family information
            'father_name' => 'nullable|string|max:255',
            'father_education' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'father_age' => 'nullable|integer|min:18|max:100',
            'mother_name' => 'nullable|string|max:255',
            'mother_education' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'mother_age' => 'nullable|integer|min:18|max:100',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:50',
            'guardian_occupation' => 'nullable|string|max:255',
            'guardian_contact' => 'nullable|string|max:20',
            'parent_marital_status' => 'nullable|string|max:50',
            
            // Other required information
            'number_of_children' => 'required|integer|min:1|max:20',
            'birth_order' => 'nullable|string|max:20',
            'finances' => 'required|array',
            'monthly_income' => 'required|string|max:100',
            'weekly_allowance' => 'nullable|string|max:50',
            
            // Health information
            'academic_health' => 'nullable|array',
            'physical_health' => 'nullable|string|max:500',
            'psych_consultation' => 'nullable|array',
            'allergies' => 'nullable|string|max:255',
            'medications' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            
            // Interest and hobbies
            'fav_subjects' => 'required|string|max:255',
            'least_subjects' => 'required|string|max:255',
            'hobbies' => 'required|string|max:255',
            'skills' => 'nullable|string|max:255',
            'extra_curricular' => 'nullable|string|max:255',
            
            // Intake interview - all optional
            'father' => 'nullable|string|max:255',
            'mother' => 'nullable|string|max:255',
            'family' => 'nullable|string|max:255',
            'siblings' => 'nullable|string|max:255',
            'childhood' => 'nullable|string|max:255',
            'friends' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'dream' => 'nullable|string|max:255',
            'weakness' => 'nullable|string|max:255',
            'fear' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
            'future_vision' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Store a new student inventory form
     */
    public function store(Request $request)
    {
        // Get all form data first
        $allData = $request->all();
        
        // Validate form data using custom validation function
        $validated = $this->validateInventoryForm($request);
        
        // Check if student number already exists and is not empty
        if (!empty($validated['student_number'])) {
            $existingRecord = Inventory::where('student_number', $validated['student_number'])->first();
            
            if ($existingRecord) {
                // Update existing record instead of creating new one
                try {
                    DB::beginTransaction();
                    
                    // Handle file upload if new photo is provided
                    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                        // Delete old photo if exists
                        if (!empty($existingRecord->photo)) {
                            Storage::disk('public')->delete($existingRecord->photo);
                        }
                        
                        $photoPath = $request->file('photo')->store('student_photos', 'public');
                        $validated['photo'] = $photoPath;
                    }
                    
                    // Handle array fields properly
                    foreach (['staying_place', 'finances', 'academic_health', 'psych_consultation'] as $field) {
                        // If field exists in request but not in validated data, add it
                        if (!isset($validated[$field]) && isset($allData[$field])) {
                            $validated[$field] = $allData[$field];
                        }
                        
                        // Convert array fields to string for storage
                        if (isset($validated[$field]) && is_array($validated[$field])) {
                            $validated[$field] = implode(', ', $validated[$field]);
                        }
                    }
                    
                    // Update the record
                    $existingRecord->update($validated);
                    
                    DB::commit();
                    
                    // Fix: Use student.show instead of inventory.show to match show method
                    return redirect()
                        ->route('student.show', $existingRecord->id)
                        ->with('success', 'Inventory record updated successfully. You can now download your PDF.');
                        
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Form update error: ' . $e->getMessage());
                    return back()->with('error', 'There was an error updating your form: ' . $e->getMessage())->withInput();
                }
            }
        }
        
        // If no existing record found or student number is empty, create new record
        try {
            DB::beginTransaction();
            
            // Handle file upload for new record
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photoPath = $request->file('photo')->store('student_photos', 'public');
                $validated['photo'] = $photoPath;
            }
            
            // Handle array fields properly
            foreach (['staying_place', 'finances', 'academic_health', 'psych_consultation'] as $field) {
                // If field exists in request but not in validated data, add it
                if (!isset($validated[$field]) && isset($allData[$field])) {
                    $validated[$field] = $allData[$field];
                }
                
                // Convert array fields to string for storage
                if (isset($validated[$field]) && is_array($validated[$field])) {
                    $validated[$field] = implode(', ', $validated[$field]);
                } elseif (!isset($validated[$field]) && $field === 'staying_place') {
                    // Ensure required array fields have at least an empty value
                    $validated[$field] = '';
                }
            }
            
            // Generate a unique form ID with timestamp for better uniqueness
            $validated['form_id'] = 'INV-' . uniqid() . '-' . time();
            
            // Create new record
            $inventory = Inventory::create($validated);
            
            DB::commit();
            
            // Redirect with success message and option to download PDF
            return redirect()
                ->route('student.show', $inventory->id)
                ->with('success', 'Inventory form submitted successfully. You can now download your PDF.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Form submission error: ' . $e->getMessage());
            return back()->with('error', 'There was an error submitting your form: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the inventory form
     */
    public function show($id)
    {
        // Connect to database and retrieve the inventory record
        $inventory = Inventory::findOrFail($id);
        
        return view('student.show', compact('inventory'));
    }

    /**
     * Download PDF using file-based approach
     */
    public function downloadPdf($id)
    {
        // Set basic PHP configuration
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
        
        try {
            // Retrieve the inventory record by ID
            $inventory = Inventory::findOrFail($id);
            
            // Process array fields
            $arrayFields = ['staying_place', 'finances', 'academic_health', 'psych_consultation'];
            $data = $inventory->toArray();
            
            foreach ($arrayFields as $field) {
                if (isset($data[$field]) && !is_array($data[$field]) && !empty($data[$field])) {
                    $data[$field] = explode(', ', $data[$field]);
                }
            }
            
            // Handle student photo if exists
            $photoBase64 = null;
            if (!empty($inventory->photo) && Storage::disk('public')->exists($inventory->photo)) {
                $photoPath = Storage::disk('public')->path($inventory->photo);
                $photoContent = file_get_contents($photoPath);
                if ($photoContent !== false) {
                    $photoBase64 = 'data:image/jpeg;base64,' . base64_encode($photoContent);
                }
            }
            
            // Add school logo if exists
            $logoBase64 = null;
            $logoPath = public_path('images/school_logo.png');
            if (file_exists($logoPath)) {
                $logoContent = file_get_contents($logoPath);
                if ($logoContent !== false) {
                    $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);
                }
            }
            
            // Prepare PDF data
            $pdfData = [
                'data' => $data,
                'photoBase64' => $photoBase64, 
                'logoBase64' => $logoBase64,
                'current_timestamp' => date('F d, Y h:i A')
            ];
            
            // Generate PDF directly for download without saving to storage
            $pdf = PDF::loadView('pdf.inventory', $pdfData);
            $pdf->setPaper('a4', 'portrait');
            
            // Set filename with student name for better identification
            $filename = 'student_inventory_' . str_replace(' ', '_', strtolower($inventory->full_name)) . '_' . $inventory->form_id . '.pdf';
            
            // Return file download response
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            Log::error('PDF Error: ' . $e->getMessage());
            return back()->with('error', 'Hindi ma-generate ang PDF: ' . $e->getMessage());
        }
    }
}