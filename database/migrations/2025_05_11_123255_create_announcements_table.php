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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('announcement_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('target_audience');
            $table->datetime('publish_date');
            $table->datetime('expiry_date');
            $table->enum('status', ['draft', 'scheduled', 'active', 'expired'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
