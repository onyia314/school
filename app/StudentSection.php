<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * student_sections table keep track of both current and previous sections of a student
 * per semester
 *
 */
class StudentSection extends Model
{
    protected $guarded = [];

    public function student(){
        return $this->belongsTo('App\User');
    }
    public function section(){
        return $this->belongsTo('App\Section');
    }
    public function semester(){
        return $this->belongsTo('App\Semester');
    }

}
