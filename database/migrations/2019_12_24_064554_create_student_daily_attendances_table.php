<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDailyAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_daily_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('semester_id'); //semester the daily attendance was taken
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('student_id');
            $table->unsignedTinyInteger('status');
            $table->unsignedInteger('takenBy_id'); //teacher teaching the course at that moment
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
        Schema::dropIfExists('student_daily_attendances');
    }
}
