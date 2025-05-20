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
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreignId('course_format_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 10, 2); // Decimal with larger precision
            $table->decimal('discount', 5, 2)->nullable(); // Discount percentage
            $table->decimal('discounted_price', 10, 2)->nullable(); // Final price after discount // Discount column, nullable
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('capacity')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('reviews_count')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
