<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('course_id')->nullable();  // null for staff and student general attendace
            $table->unsignedInteger('semester_id');
            $table->unsignedInteger('section_id')->nullable();  //null for staff
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('status');
            $table->unsignedInteger('takenBy_id'); //who took the attendance? (any teacher or admin can)
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
        Schema::dropIfExists('attendances');
    }
}
