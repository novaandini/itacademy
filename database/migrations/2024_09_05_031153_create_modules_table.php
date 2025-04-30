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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->uuid('course_id');
            $table->string('module_id')->index();
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('learning_objectives')->nullable();
            $table->text('content')->nullable();
            $table->integer('duration_hours')->nullable();
            $table->text('activities')->nullable();
            $table->text('assessment_type')->nullable();
            $table->integer('passing_score')->nullable();
            $table->string('module_status')->nullable();
            $table->text('resources')->nullable();
            $table->text('prerequisites')->nullable();
            $table->enum('certificate_eligibility', ['yes', 'no']);
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
