<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('religion')->default('');
            $table->enum('gender' , ['male' , 'female'])->default('male');
            $table->string('nationality')->default('');
            $table->string('state_of_origin')->default('');
            $table->string('address')->default('');
            $table->dateTime('birthday')->default( now() );
            $table->string('qualification')->default('');
            $table->string('next_of_kin')->default('');
            $table->string('next_of_kin_phone')->default('');
            $table->string('referee')->default('');
            $table->string('referee_phone')->default('');
            $table->string('previous')->default('');
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
        Schema::dropIfExists('staff_infos');
    }
}
