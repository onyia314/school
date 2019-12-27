<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->bigIncrements('id'); //it can't be zero as 0
            $table->string('semester_name');
            $table->unsignedInteger('session_id');
            $table->enum('status' , ['open' , 'locked'])->default('locked'); //editable?
            $table->dateTime('start_date')->unique();
            $table->dateTime('end_date')->unique();
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
        Schema::dropIfExists('semesters');
    }
}
