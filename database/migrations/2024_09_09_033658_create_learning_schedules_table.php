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
        Schema::create('learning_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Day of the week
            $table->uuid('course_id'); // Foreign key to courses table
            $table->text('material')->nullable(); // Material for the schedule
            $table->time('start_time');
            $table->time('end_time');  // Time for the schedule
            $table->uuid('user_id'); // Foreign key to users table for instructor
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_schedules');
    }
};
