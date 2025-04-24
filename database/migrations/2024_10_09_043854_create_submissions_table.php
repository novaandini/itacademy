<?php

// database/migrations/xxxx_xx_xx_create_submissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id'); 
            $table->uuid('user_id'); 
            $table->text('answer_text')->nullable();
            $table->string('file')->nullable(); 
            $table->string('status_review')->default('pending'); 
            $table->integer('grade')->nullable(); 
            $table->text('feedback')->nullable(); 
            $table->timestamps();

            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
