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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id'); // Foreign key to users table, with cascading delete
            $table->uuid('course_id'); // Foreign key to courses table, with cascading delete
            $table->string('certificate_number');
            $table->text('description'); // Description of the certification
            $table->enum('status', ['pending', 'approved', 'rejected'])->nullable(); // URL or path to the image, make nullable if it's optional
            $table->date('date')->nullable(); // Date field for certification date
            $table->json('score');
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
        Schema::dropIfExists('certifications');
    }
};
