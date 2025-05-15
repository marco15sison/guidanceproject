<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counsellor;
use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentFeedback;
use App\Models\CounsellingNote;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CounsellingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting counselling system setup with MS. NOIME CARLOS...');
        
        // First, check if MS. NOIME CARLOS already exists
        $existingCounsellor = Counsellor::whereRaw('LOWER(name) LIKE ?', ['%noime carlos%'])->first();
        
        if ($existingCounsellor) {
            $this->command->info('MS. NOIME CARLOS already exists (ID: ' . $existingCounsellor->id . '). Updating details...');
            
            // Ensure proper state
            $existingCounsellor->update([
                'name' => 'MS. NOIME CARLOS', // Standardize name format
                'email' => 'noime.carlos@psu.edu.ph',
                'phone' => '(045) 987-6543',
                'specialization' => 'All Counselling Services',
                'expertise1' => 'Academic Counselling',
                'expertise2' => 'Career Counselling',
                'expertise3' => 'Personal Counselling',
                'biography' => 'MS. NOIME CARLOS is a dedicated counsellor with extensive experience in all areas of student counselling. She specializes in providing comprehensive support for academic, career, and personal development needs of students at PSU.',
                'education' => "Ph.D. in Counselling Psychology, University of the Philippines\nM.A. in Educational Psychology, Ateneo de Manila University\nB.S. in Psychology, De La Salle University",
                'specializations' => "Academic Performance Improvement\nCareer Planning and Development\nPersonal Growth and Mental Health\nEmotional Well-being\nRelationship Counselling",
                'available_days' => 'Monday,Tuesday,Wednesday,Thursday,Friday',
                'available_hours' => '9:00 AM - 5:00 PM',
                'is_active' => true,
            ]);
            
            // Direct DB update to ensure is_active is true
            DB::table('counsellors')
                ->where('id', $existingCounsellor->id)
                ->update([
                    'is_active' => true,
                    'updated_at' => Carbon::now()
                ]);
                
            $counsellor = $existingCounsellor;
        } else {
            $this->command->info('Creating MS. NOIME CARLOS as the sole counsellor...');
            
            // Create MS. NOIME CARLOS
            $counsellor = Counsellor::create([
                'name' => 'MS. NOIME CARLOS',
                'email' => 'noime.carlos@psu.edu.ph',
                'phone' => '(045) 987-6543',
                'specialization' => 'All Counselling Services',
                'expertise1' => 'Academic Counselling',
                'expertise2' => 'Career Counselling',
                'expertise3' => 'Personal Counselling',
                'biography' => 'MS. NOIME CARLOS is a dedicated counsellor with extensive experience in all areas of student counselling. She specializes in providing comprehensive support for academic, career, and personal development needs of students at PSU.',
                'education' => "Ph.D. in Counselling Psychology, University of the Philippines\nM.A. in Educational Psychology, Ateneo de Manila University\nB.S. in Psychology, De La Salle University",
                'specializations' => "Academic Performance Improvement\nCareer Planning and Development\nPersonal Growth and Mental Health\nEmotional Well-being\nRelationship Counselling",
                'available_days' => 'Monday,Tuesday,Wednesday,Thursday,Friday',
                'available_hours' => '9:00 AM - 5:00 PM',
                'is_active' => true,
            ]);
            
            // Direct DB update to ensure is_active is true
            DB::table('counsellors')
                ->where('id', $counsellor->id)
                ->update(['is_active' => true]);
        }
        
        $this->command->info('MS. NOIME CARLOS is ready (ID: ' . $counsellor->id . ')');
        
        // Remove all other counsellors if they exist
        $this->command->info('Removing any counsellors other than MS. NOIME CARLOS...');
        Counsellor::where('id', '!=', $counsellor->id)->delete();
        $this->command->info('MS. NOIME CARLOS is now the only counsellor in the system.');
        
        // Create sample appointments (if users exist)
        $students = User::where('user_type', 'student')->take(5)->get();
        
        if ($students->count() > 0) {
            $this->command->info('Creating sample appointments for ' . $students->count() . ' students...');
            
            $statuses = ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'];
            $serviceTypes = ['academic', 'career', 'personal'];
            
            foreach ($students as $student) {
                // Create 2-3 appointments per student
                $appointmentCount = rand(2, 3);
                
                for ($i = 0; $i < $appointmentCount; $i++) {
                    $status = $statuses[array_rand($statuses)];
                    $serviceType = $serviceTypes[array_rand($serviceTypes)];
                    
                    // Create appointment date (between last month and next month)
                    $appointmentDate = Carbon::now()->subDays(rand(-30, 30))->format('Y-m-d');
                    
                    // Create appointment time (9am to 4pm)
                    $hour = rand(9, 16);
                    $appointmentTime = sprintf('%02d:00:00', $hour);
                    
                    $appointment = Appointment::create([
                        'student_id' => $student->id,
                        'counsellor_id' => $counsellor->id,
                        'service_type' => $serviceType,
                        'appointment_date' => $appointmentDate,
                        'appointment_time' => $appointmentTime,
                        'reason' => 'Sample reason for seeking ' . $serviceType . ' counselling.',
                        'status' => $status,
                    ]);
                    
                    // If cancelled, add cancellation details
                    if ($status === 'cancelled') {
                        $appointment->cancellation_reason = 'Sample cancellation reason.';
                        $appointment->cancelled_at = Carbon::now()->subDays(rand(1, 10));
                        $appointment->cancelled_by = $student->id;
                        $appointment->save();
                    }
                    
                    // If completed, maybe add feedback
                    if ($status === 'completed' && rand(0, 1) === 1) {
                        AppointmentFeedback::create([
                            'appointment_id' => $appointment->id,
                            'rating' => rand(3, 5),
                            'comments' => 'Sample feedback comment for the counselling session.',
                            'submitted_by' => $student->id,
                        ]);
                    }
                    
                    // If in progress or completed, add counselling notes
                    if (in_array($status, ['in_progress', 'completed'])) {
                        CounsellingNote::create([
                            'appointment_id' => $appointment->id,
                            'author_id' => $counsellor->id,
                            'author_type' => 'counsellor',
                            'content' => 'Sample counselling note about the session.',
                            'is_private' => rand(0, 1) === 1,
                        ]);
                    }
                }
            }
            
            $this->command->info('Created ' . (count($students) * $appointmentCount) . ' sample appointments with MS. NOIME CARLOS.');
        } else {
            $this->command->info('No students found. Skipping appointment creation.');
        }
        
        // Create a user account for MS. NOIME CARLOS if not exists
        $userExists = User::where('email', 'noime.carlos@psu.edu.ph')->exists();
        
        if (!$userExists) {
            $this->command->info('Creating user account for MS. NOIME CARLOS...');
            
            $user = User::create([
                'name' => 'MS. NOIME CARLOS',
                'email' => 'noime.carlos@psu.edu.ph',
                'password' => bcrypt('password123'), // Change this in production
                'user_type' => 'faculty',
                'is_active' => true,
                'email_verified_at' => now()
            ]);
            
            // Link the user to the counsellor
            $counsellor->update(['user_id' => $user->id]);
            
            $this->command->info('User account created for MS. NOIME CARLOS (ID: ' . $user->id . ')');
        }
        
        $this->command->info('Counselling system setup completed successfully with MS. NOIME CARLOS as the sole counsellor.');
    }
}