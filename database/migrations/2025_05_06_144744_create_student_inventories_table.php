<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('form_id')->unique();
            $table->string('student_number')->nullable(); // Added student number field
            $table->string('photo')->nullable();
            $table->string('full_name');
            $table->string('course');
            $table->string('year_level');
            $table->date('date_of_birth');
            $table->string('place_of_birth')->nullable();
            $table->string('gender');
            $table->integer('age')->nullable();
            $table->string('civil_status');
            $table->string('religion')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('email')->nullable();
            $table->text('staying_place');
            $table->string('high_school_name')->nullable();
            $table->string('high_school_type');
            $table->string('previous_school_address')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('high_school_gpa')->nullable();
            $table->text('awards')->nullable();
            $table->string('previous_college_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_education')->nullable();
            $table->string('father_occupation')->nullable();
            $table->integer('father_age')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_education')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->integer('mother_age')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->string('parent_marital_status')->nullable();
            $table->integer('number_of_children');
            $table->string('birth_order')->nullable();
            $table->text('finances');
            $table->string('monthly_income');
            $table->string('weekly_allowance')->nullable();
            $table->text('academic_health')->nullable();
            $table->text('physical_health')->nullable();
            $table->text('psych_consultation')->nullable();
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('fav_subjects');
            $table->text('least_subjects');
            $table->text('hobbies');
            $table->text('skills')->nullable();
            $table->text('extra_curricular')->nullable();
            $table->text('father')->nullable(); // Made nullable since these are optional in the form
            $table->text('mother')->nullable();
            $table->text('family')->nullable();
            $table->text('siblings')->nullable();
            $table->text('childhood')->nullable();
            $table->text('friends')->nullable();
            $table->text('school')->nullable();
            $table->text('dream')->nullable();
            $table->text('weakness')->nullable();
            $table->text('fear')->nullable();
            $table->text('strength')->nullable();
            $table->text('future_vision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_inventories');
    }
}