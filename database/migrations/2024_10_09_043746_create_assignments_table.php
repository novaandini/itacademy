<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->uuid('module_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // Menyimpan file/gambar
            $table->timestamp('deadline')->nullable(); // Menyimpan deadline
            $table->timestamps();

            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
