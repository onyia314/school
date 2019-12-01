<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('religion');
            $table->enum('gender' , ['male' , 'female']);
            $table->string('nationality');
            $table->string('state_of_origin');
            $table->string('address');
            $table->dateTime('birthday');
            $table->string('session_id'); //the session the student was registered
            $table->string('father_name');
            $table->string('father_phone')->nullable();
            $table->string('mother_name');
            $table->string('mother_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_infos');
    }
}
