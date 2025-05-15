<?php
// database/seeders/AnnouncementCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnouncementCategory;

class AnnouncementCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'General Announcements',
                'description' => 'General announcements for all students',
                'icon' => 'fa-bullhorn',
                'color' => '#0d6efd',
                'is_active' => true
            ],
            [
                'name' => 'Academic Announcements',
                'description' => 'Updates related to academic matters',
                'icon' => 'fa-graduation-cap',
                'color' => '#198754',
                'is_active' => true
            ],
            [
                'name' => 'Events & Activities',
                'description' => 'Student events and campus activities',
                'icon' => 'fa-calendar',
                'color' => '#6f42c1',
                'is_active' => true
            ],
            [
                'name' => 'Career Opportunities',
                'description' => 'Job postings and career information',
                'icon' => 'fa-briefcase',
                'color' => '#fd7e14',
                'is_active' => true
            ],
            [
                'name' => 'Campus Services',
                'description' => 'Information about campus facilities and services',
                'icon' => 'fa-building',
                'color' => '#20c997',
                'is_active' => true
            ],
            [
                'name' => 'Emergency Alerts',
                'description' => 'Urgent announcements and emergency information',
                'icon' => 'fa-exclamation-triangle',
                'color' => '#dc3545',
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            AnnouncementCategory::create($category);
        }
    }
}

// database/seeders/AnnouncementSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcements = [
            [
                'category_id' => 1, // General Announcements
                'title' => 'Campus Wi-Fi Upgrade Schedule',
                'content' => '<p>Dear Students,</p>
                <p>We\'re pleased to announce that campus-wide Wi-Fi upgrades will be taking place over the next two weeks to improve connectivity and speed across all university buildings.</p>
                <p>During the upgrade process, you may experience brief interruptions in wireless service in the following locations:</p>
                <ul>
                    <li><strong>April 15:</strong> Main Library and Student Center (7:00 AM - 10:00 AM)</li>
                    <li><strong>April 17:</strong> Science Building and Engineering Complex (7:00 AM - 10:00 AM)</li>
                    <li><strong>April 20:</strong> Residence Halls A, B, and C (2:00 AM - 5:00 AM)</li>
                    <li><strong>April 22:</strong> Residence Halls D, E, and F (2:00 AM - 5:00 AM)</li>
                </ul>
                <p>The upgraded network will provide:</p>
                <ul>
                    <li>Faster connection speeds (up to 1 Gbps)</li>
                    <li>Better coverage in previously weak signal areas</li>
                    <li>Improved support for multiple devices</li>
                    <li>Enhanced security features</li>
                </ul>
                <p>No changes to your device settings will be required to connect to the upgraded network.</p>
                <p>If you experience any connectivity issues after the upgrades are complete, please contact IT Support at support@university.edu or visit the IT Help Desk in the Student Center.</p>
                <p>Thank you for your patience as we improve our campus infrastructure.</p>
                <p>Best regards,<br>Campus IT Services</p>',
                'target_audience' => 'All Students',
                'publish_date' => Carbon::now()->subDays(5),
                'expiry_date' => Carbon::now()->addDays(10),
                'status' => 'active',
                'is_featured' => true,
                'views' => 145
            ],
            [
                'category_id' => 1, // General Announcements
                'title' => 'Library Hours Extended for Finals',
                'content' => '<p>Dear Students,</p>
                <p>As we approach the final examination period, we are pleased to announce extended library hours to support your study needs.</p>
                <p>The Main Library will be open 24 hours from May 1 to May 15, 2025. Additional study spaces will be available on the second and third floors, with quiet zones designated throughout the building.</p>
                <p>Other changes during this period include:</p>
                <ul>
                    <li>Extended laptop loan periods (up to 12 hours)</li>
                    <li>Additional power outlets in all study areas</li>
                    <li>Increased staff availability for research assistance</li>
                    <li>Free coffee service from 9:00 PM to 6:00 AM</li>
                </ul>
                <p>Please remember to bring your student ID card, as access to the library between 10:00 PM and 7:00 AM will require ID verification.</p>
                <p>Good luck with your exams!</p>
                <p>Best regards,<br>University Library Services</p>',
                'target_audience' => 'All Students',
                'publish_date' => Carbon::now()->subDays(3),
                'expiry_date' => Carbon::now()->addDays(30),
                'status' => 'active',
                'is_featured' => true,
                'views' => 210
            ],
            [
                'category_id' => 2, // Academic Announcements
                'title' => 'Fall 2025 Registration Timeline',
                'content' => '<p>Dear Students,</p>
                <p>The Office of the Registrar is announcing the timeline for Fall 2025 course registration. Registration will be opening according to the following schedule:</p>
                <ul>
                    <li><strong>May 15:</strong> Graduate Students and Seniors (90+ credits)</li>
                    <li><strong>May 17:</strong> Juniors (60-89 credits)</li>
                    <li><strong>May 19:</strong> Sophomores (30-59 credits)</li>
                    <li><strong>May 21:</strong> Freshmen (0-29 credits)</li>
                </ul>
                <p>All registration periods begin at 8:00 AM EST on the assigned date.</p>
                <p>Before registration opens, please:</p>
                <ul>
                    <li>Clear any holds on your account</li>
                    <li>Meet with your academic advisor</li>
                    <li>Review your degree audit</li>
                    <li>Prepare a list of alternative courses in case your first choices are filled</li>
                </ul>
                <p>The course catalog for Fall 2025 is now available online. You can access it through the student portal.</p>
                <p>If you have any questions about registration, please contact the Registrar\'s Office at registrar@university.edu.</p>
                <p>Best regards,<br>Office of the Registrar</p>',
                'target_audience' => 'All Students',
                'publish_date' => Carbon::now()->subDays(1),
                'expiry_date' => Carbon::now()->addDays(45),
                'status' => 'active',
                'is_featured' => true,
                'views' => 324
            ],
            [
                'category_id' => 3, // Events & Activities
                'title' => 'Spring Festival 2025 - Call for Participants',
                'content' => '<p>Dear University Community,</p>
                <p>The Spring Festival Committee is excited to announce our annual Spring Festival, which will take place from May 5-7, 2025 on the University Commons.</p>
                <p>This year\'s theme is "Global Connections," celebrating our diverse campus community and international relationships.</p>
                <p>We are currently seeking:</p>
                <ul>
                    <li>Student performers (music, dance, theater)</li>
                    <li>Cultural clubs to host information booths</li>
                    <li>Campus organizations to organize interactive activities</li>
                    <li>Food vendors representing diverse cuisines</li>
                    <li>Volunteers to help with setup, operations, and cleanup</li>
                </ul>
                <p>If you\'re interested in participating, please complete the application form at our website: www.university.edu/springfestival by April 25, 2025.</p>
                <p>For more information, you can email us at springfestival@university.edu or visit the Student Activities Office in the Student Center, Room 203.</p>
                <p>Join us in making this year\'s Spring Festival the best one yet!</p>
                <p>Best regards,<br>Spring Festival Committee</p>',
                'target_audience' => 'All Students',
                'publish_date' => Carbon::now()->subDays(2),
                'expiry_date' => Carbon::now()->addDays(20),
                'status' => 'active',
                'is_featured' => false,
                'views' => 189
            ],
            [
                'category_id' => 4, // Career Opportunities
                'title' => 'Summer Internship Fair - April 20, 2025',
                'content' => '<p>Dear Students,</p>
                <p>The Career Development Center is hosting our annual Summer Internship Fair on Thursday, April 20, 2025, from 11:00 AM to 3:00 PM in the University Center Ballroom.</p>
                <p>Over 75 employers from various industries will be attending, offering summer internship opportunities for students of all majors. Some participating organizations include:</p>
                <ul>
                    <li>Microsoft</li>
                    <li>National Institutes of Health</li>
                    <li>Goldman Sachs</li>
                    <li>Tesla</li>
                    <li>Mayo Clinic</li>
                    <li>The Washington Post</li>
                    <li>NASA</li>
                    <li>Many more local and national employers</li>
                </ul>
                <p><strong>How to Prepare:</strong></p>
                <ul>
                    <li>Update your resume (drop-in resume reviews available until April 19)</li>
                    <li>Research participating employers on our website</li>
                    <li>Prepare your elevator pitch</li>
                    <li>Dress professionally</li>
                    <li>Bring multiple copies of your resume</li>
                </ul>
                <p>We are also offering a "Prepare for the Fair" workshop on April 17 at 5:00 PM in the Career Center.</p>
                <p>For the full list of employers and to register, please visit our website: www.university.edu/internshipfair</p>
                <p>Best regards,<br>Career Development Center</p>',
                'target_audience' => 'All Students',
                'publish_date' => Carbon::now(),
                'expiry_date' => Carbon::now()->addDays(15),
                'status' => 'active',
                'is_featured' => true,
                'views' => 278
            ],
            [
                'category_id' => 5, // Campus Services
                'title' => 'New Student Portal Features',
                'content' => '<p>Dear Students,</p>
                <p>We\'re excited to announce several new features coming to the Student Portal on April 15, 2025. These updates are based on student feedback and are designed to improve your university experience.</p>
                <p><strong>New Features Include:</strong></p>
                <ul>
                    <li><strong>Mobile App Integration:</strong> Sync your schedule, grades, and notifications with our new mobile app</li>
                    <li><strong>Enhanced Dashboard:</strong> Customizable widget layout to prioritize the information most important to you</li>
                    <li><strong>Academic Progress Tracker:</strong> Visual representation of your degree progress and remaining requirements</li>
                    <li><strong>Direct Messaging:</strong> Secure messaging system to communicate with instructors and advisors</li>
                    <li><strong>Campus Map Integration:</strong> Interactive map with real-time building hours and service information</li>
                </ul>
                <p>The portal will be unavailable from 2:00 AM to 6:00 AM on April 15 while we implement these updates. No action is required on your part.</p>
                <p>Training resources will be available on the help center, and the IT Help Desk will offer extended hours for the week following the update.</p>
                <p>For questions, please contact support@university.edu.</p>
                <p>Best regards,<br>IT Services</p>',
                'target_audience' => 'All Students',
                'publish_date' => Carbon::now()->addDays(5),
                'expiry_date' => Carbon::now()->addDays(20),
                'status' => 'scheduled',
                'is_featured' => false,
                'views' => 0
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}