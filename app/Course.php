<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function schoolClass(){
        return $this->belongsTo('App\SchoolClass' , 'class_id');
    }

    public function section(){
        return $this->belongsTo('App\Section');
    }

    public function semester(){
        return $this->belongsTo('App\Semester');
    }

    /**
     * since we don't have a teacher table let's get the teacher_id for a course
     * by defininig a relationship of courses with user
     */

     public function teacher(){
         return $this->belongsTo('App\User');
     }
}
