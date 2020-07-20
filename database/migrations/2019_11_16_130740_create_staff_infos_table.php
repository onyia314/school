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
            $table->string('religion');
            $table->enum('gender' , ['male' , 'female']);
            $table->string('nationality');
            $table->string('state_of_origin');
            $table->string('address');
            $table->date('birthday');
            $table->string('qualification');
            $table->string('next_of_kin');
            $table->string('next_of_kin_phone');
            $table->string('referee');
            $table->string('referee_phone');
            $table->string('previous');
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
