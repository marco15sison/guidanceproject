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
        Schema::create('counselling_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('author_id');
            $table->string('author_type'); // 'admin', 'counsellor', etc.
            $table->text('content');
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            
            // Index for faster lookups
            $table->index(['author_id', 'author_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselling_notes');
    }
};