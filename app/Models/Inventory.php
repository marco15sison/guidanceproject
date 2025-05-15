<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_inventories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id',
        'student_number',
        'photo',
        'full_name',
        'course',
        'year_level',
        'date_of_birth',
        'place_of_birth',
        'gender',
        'age',
        'civil_status',
        'religion',
        'citizenship',
        'contact_number',
        'residential_address',
        'permanent_address',
        'email',
        'staying_place',
        'high_school_name',
        'high_school_type',
        'previous_school_address',
        'year_graduated',
        'high_school_gpa',
        'awards',
        'previous_college_name',
        'father_name',
        'father_education',
        'father_occupation',
        'father_age',
        'mother_name',
        'mother_education',
        'mother_occupation',
        'mother_age',
        'guardian_name',
        'guardian_relationship',
        'guardian_occupation',
        'guardian_contact',
        'parent_marital_status',
        'number_of_children',
        'birth_order',
        'finances',
        'monthly_income',
        'weekly_allowance',
        'academic_health',
        'physical_health',
        'psych_consultation',
        'allergies',
        'medications',
        'emergency_contact',
        'fav_subjects',
        'least_subjects',
        'hobbies',
        'skills',
        'extra_curricular',
        'father',
        'mother',
        'family',
        'siblings',
        'childhood',
        'friends',
        'school',
        'dream',
        'weakness',
        'fear',
        'strength',
        'future_vision',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'age' => 'integer',
        'father_age' => 'integer',
        'mother_age' => 'integer',
        'number_of_children' => 'integer',
    ];
}