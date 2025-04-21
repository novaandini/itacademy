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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('slug');
            $table->unsignedBigInteger('category_id');
            $table->date('date');
            $table->longText('content');
            $table->text('image');
            $table->enum('status', ['show', 'hide']);
            $table->text('tags')->nullable();
            $table->string('caption')->nullable();
            $table->text('keyword')->nullable();
            $table->integer('hit')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category_news')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
