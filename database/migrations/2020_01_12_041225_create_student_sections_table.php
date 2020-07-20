<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /**
         * this table will keep track of the sections(arms) a student belonged to
         * per academic semester and handles student promotion
         * 
         * promotion is done per semester to ensure flexibility of the software
         */
        Schema::create('student_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('semester_id');
            $table->enum('status' , ['promoted','demoted','repeat','left','graduated','registered']);
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
        Schema::dropIfExists('student_sections');
    }
}
