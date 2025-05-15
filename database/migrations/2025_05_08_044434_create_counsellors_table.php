<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('counsellors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('specialization');
            $table->string('expertise1');
            $table->string('expertise2');
            $table->string('expertise3')->nullable();
            $table->text('biography')->nullable();
            $table->text('education')->nullable();
            $table->text('specializations')->nullable();
            $table->string('available_days'); // Comma-separated days (e.g., 'monday,tuesday,wednesday')
            $table->string('available_hours')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellors');
    }
};