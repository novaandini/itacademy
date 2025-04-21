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
        Schema::create('menumanagers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->string('url');
            $table->enum('target', ['same_window', 'new_window']);
            $table->enum('status', ['hide', 'show']);
            $table->timestamps();

            $table->foreign('parent_id')
            ->references('id')
            ->on('menumanagers')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menumanagers');
    }
};
