<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PSU Student Inventory Form</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 10px;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 10px;
            width: 100%;
        }
        /* Replace all the logo CSS rules with just this one */
        .logo {
            width: 100px;
            height: auto;
            display: inline-block;
            vertical-align: middle;
            margin-right: 15px;
        }
        
        .header-text {
            display: inline-block;
            vertical-align: middle;
            margin-left: 15px;
        }
        h1 {
            color: #1a5276;
            font-size: 16pt;
            margin: 0;
            font-weight: bold;
        }
        h2 {
            color: #1a5276;
            font-size: 14pt;
            margin-top: 5px;
            font-weight: bold;
        }
        .photo-container {
            float: right;
            width: 100px;
            height: 100px;
            border: 1px solid #666;
            margin-left: 15px;
            margin-bottom: 15px;
            background-color: #f5f5f5;
            text-align: center;
        }
        .section {
            margin-top: 15px;
            margin-bottom: 20px;
            clear: both;
            page-break-inside: avoid;
            width: 100%;
        }
        .section-title {
            background-color: #1a5276;
            color: white;
            padding: 5px 10px;
            font-size: 12pt;
            margin-bottom: 10px;
            font-weight: bold;
            border-radius: 3px;
        }
        .form-group {
            margin-bottom: 8px;
            clear: both;
            width: 100%;
            display: table;
            page-break-inside: avoid;
        }
        .label {
            font-weight: bold;
            width: 38%;
            float: left;
            font-size: 10pt;
            padding-right: 2%;
        }
        .value {
            width: 60%;
            float: left;
            font-size: 10pt;
            padding-bottom: 3px;
            border-bottom: 1px dotted #ccc;
            min-height: 14pt;
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .page-break {
            page-break-after: always;
            clear: both;
            height: 0;
        }
        .signature {
            margin-top: 30px;
            text-align: center;
            page-break-inside: avoid;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 250px;
            margin: 5px auto;
        }
        .footer {
            text-align: center;
            font-size: 8pt;
            color: #666;
            padding: 5px 0;
            margin-top: 20px;
            border-top: 1px solid #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<div class="header" style="margin-bottom: 20px; text-align: center; border-bottom: 2px solid #1a5276; padding-bottom: 15px; width: 100%;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 120px; vertical-align: middle; padding-right: 15px;">
                @if(!empty($logoBase64))
                    <img src="data:image/png;base64,{{ $logoBase64 }}" alt="PSU Logo" style="width: 100px; height: auto; display: block;">
                @else
                    <div style="width: 100px; height: 100px; background-color: #1a5276; color: white; text-align: center; line-height: 100px; font-weight: bold;">PSU</div>
                @endif
            </td>
            <td style="vertical-align: middle; text-align: left;">
                <h1 style="color: #62761a; font-size: 18pt; margin: 0; font-weight: bold;">PANGASINAN STATE UNIVERSITY</h1>
                <h2 style="color: #1a5276; font-size: 14pt; margin-top: 5px; margin-bottom: 0; font-weight: bold;">STUDENT INDIVIDUAL INVENTORY FORM</h2>
            </td>
        </tr>
    </table>
</div>
<!-- Student photo part -->
<div class="photo-container">
    @if(isset($photoBase64) && !empty($photoBase64))
        <img src="data:image/jpeg;base64,{{ $photoBase64 }}" alt="Student Photo" style="max-width:100px;max-height:100px;">
    @else
        <div style="width:100px;height:100px;line-height:100px;text-align:center;color:#999;border:1px dashed #ccc;">
            No Photo
        </div>
    @endif
</div>

    <!-- PERSONAL INFORMATION SECTION -->
    <div class="section">
        <div class="section-title">PERSONAL INFORMATION</div>
        
        <div class="form-group">
            <div class="label">Name:</div>
            <div class="value">{{ $data['full_name'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Student Number:</div>
            <div class="value">{{ $data['student_number'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Course:</div>
            <div class="value">{{ $data['course'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Year Level:</div>
            <div class="value">{{ $data['year_level'] ?? 'N/A' }}</div>
        </div>
        
        <table>
            <tr>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Date of Birth:</div>
                        <div class="value">{{ isset($data['date_of_birth']) && $data['date_of_birth'] ? date('F d, Y', strtotime($data['date_of_birth'])) : 'N/A' }}</div>
                    </div>
                </td>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Place of Birth:</div>
                        <div class="value">{{ $data['place_of_birth'] ?? 'N/A' }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Gender:</div>
                        <div class="value">{{ $data['gender'] ?? 'N/A' }}</div>
                    </div>
                </td>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Civil Status:</div>
                        <div class="value">{{ $data['civil_status'] ?? 'N/A' }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Religion:</div>
                        <div class="value">{{ $data['religion'] ?? 'N/A' }}</div>
                    </div>
                </td>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Citizenship:</div>
                        <div class="value">{{ $data['citizenship'] ?? 'N/A' }}</div>
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="form-group">
            <div class="label">Contact Number:</div>
            <div class="value">{{ $data['contact_number'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Email Address:</div>
            <div class="value">{{ $data['email'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Residential Address:</div>
            <div class="value">{{ $data['residential_address'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Permanent Address:</div>
            <div class="value">{{ $data['permanent_address'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Places where you stay:</div>
            <div class="value">{{ is_array($data['staying_place'] ?? null) ? implode(', ', $data['staying_place']) : ($data['staying_place'] ?? 'N/A') }}</div>
        </div>
    </div>

    <!-- EDUCATIONAL BACKGROUND SECTION -->
    <div class="section">
        <div class="section-title">EDUCATIONAL BACKGROUND</div>
        
        <div class="form-group">
            <div class="label">Name of High School:</div>
            <div class="value">{{ $data['high_school_name'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Type of High School:</div>
            <div class="value">{{ $data['high_school_type'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Address of Previous School:</div>
            <div class="value">{{ $data['previous_school_address'] ?? 'N/A' }}</div>
        </div>
        
        <table>
            <tr>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">Year Graduated:</div>
                        <div class="value">{{ $data['year_graduated'] ?? 'N/A' }}</div>
                    </div>
                </td>
                <td style="width:50%">
                    <div class="form-group">
                        <div class="label">High School GPA:</div>
                        <div class="value">{{ $data['high_school_gpa'] ?? 'N/A' }}</div>
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="form-group">
            <div class="label">Honors/Special Awards:</div>
            <div class="value">{{ $data['awards'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Name of Previous College:</div>
            <div class="value">{{ $data['previous_college_name'] ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- FAMILY INFORMATION SECTION -->
    <div class="section">
        <div class="section-title">FAMILY INFORMATION</div>
        
        <div class="form-group">
            <div class="label">Father's Name:</div>
            <div class="value">{{ $data['father_name'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Father's Educational Attainment:</div>
            <div class="value">{{ $data['father_education'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Father's Occupation:</div>
            <div class="value">{{ $data['father_occupation'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Father's Age:</div>
            <div class="value">{{ $data['father_age'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Mother's Name:</div>
            <div class="value">{{ $data['mother_name'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Mother's Educational Attainment:</div>
            <div class="value">{{ $data['mother_education'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Mother's Occupation:</div>
            <div class="value">{{ $data['mother_occupation'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Mother's Age:</div>
            <div class="value">{{ $data['mother_age'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Guardian's Name:</div>
            <div class="value">{{ $data['guardian_name'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Guardian's Relationship:</div>
            <div class="value">{{ $data['guardian_relationship'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Guardian's Occupation:</div>
            <div class="value">{{ $data['guardian_occupation'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Guardian's Contact Number:</div>
            <div class="value">{{ $data['guardian_contact'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Parents' Marital Relationship:</div>
            <div class="value">{{ $data['parent_marital_status'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Number of Children in Family:</div>
            <div class="value">{{ $data['number_of_children'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Birth Order:</div>
            <div class="value">{{ $data['birth_order'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Who finances your schooling:</div>
            <div class="value">{{ is_array($data['finances'] ?? null) ? implode(', ', $data['finances']) : ($data['finances'] ?? 'N/A') }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Total Family Monthly Income:</div>
            <div class="value">{{ $data['monthly_income'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Weekly Allowance:</div>
            <div class="value">{{ $data['weekly_allowance'] ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- HEALTH INFORMATION SECTION -->
    <div class="section">
        <div class="section-title">HEALTH INFORMATION</div>
        
        <div class="form-group">
            <div class="label">Academic Health Problems:</div>
            <div class="value">{{ is_array($data['academic_health'] ?? null) ? implode(', ', $data['academic_health']) : ($data['academic_health'] ?? 'None specified') }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Physical Health Concerns:</div>
            <div class="value">{{ $data['physical_health'] ?? 'None specified' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Psychological Consultation:</div>
            <div class="value">{{ is_array($data['psych_consultation'] ?? null) ? implode(', ', $data['psych_consultation']) : ($data['psych_consultation'] ?? 'None specified') }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Allergies:</div>
            <div class="value">{{ $data['allergies'] ?? 'None specified' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Medications:</div>
            <div class="value">{{ $data['medications'] ?? 'None specified' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Emergency Contact:</div>
            <div class="value">{{ $data['emergency_contact'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- INTERESTS AND HOBBIES SECTION -->
    <div class="section">
        <div class="section-title">INTERESTS AND HOBBIES</div>
        
        <div class="form-group">
            <div class="label">Favorite Subjects:</div>
            <div class="value">{{ $data['fav_subjects'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Least Favorite Subjects:</div>
            <div class="value">{{ $data['least_subjects'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Hobbies:</div>
            <div class="value">{{ $data['hobbies'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Skills and Talents:</div>
            <div class="value">{{ $data['skills'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">Extra-curricular Activities:</div>
            <div class="value">{{ $data['extra_curricular'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- INTAKE INTERVIEW SECTION -->
    <div class="section">
        <div class="section-title">INTAKE INTERVIEW</div>
        
        <div class="form-group">
            <div class="label">My father:</div>
            <div class="value">{{ $data['father'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My mother:</div>
            <div class="value">{{ $data['mother'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My family:</div>
            <div class="value">{{ $data['family'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My siblings:</div>
            <div class="value">{{ $data['siblings'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My childhood:</div>
            <div class="value">{{ $data['childhood'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My friends:</div>
            <div class="value">{{ $data['friends'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My school:</div>
            <div class="value">{{ $data['school'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My dream:</div>
            <div class="value">{{ $data['dream'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My weakness:</div>
            <div class="value">{{ $data['weakness'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">I am afraid:</div>
            <div class="value">{{ $data['fear'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">My strength:</div>
            <div class="value">{{ $data['strength'] ?? 'N/A' }}</div>
        </div>
        
        <div class="form-group">
            <div class="label">In 5 years, I see myself:</div>
            <div class="value">{{ $data['future_vision'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- FOOTER SECTION -->
<div class="footer">
    <p>PSU Student Individual Inventory Form | Generated on {{ $current_timestamp ?? date('F d, Y h:i A') }}</p>
    <p>Form ID: {{ $data['form_id'] ?? uniqid('INV-') }}</p>
    <p>Submission Date: {{ isset($data['created_at']) ? date('F d, Y h:i A', strtotime($data['created_at'])) : 'N/A' }}</p>
</div>
</body>
</html>