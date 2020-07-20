<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = [];

    public function schoolSession(){
        return $this->belongsTo('App\SchoolSession' , 'session_id');
    }

    public function courses(){
        return $this->hasMany('App\Course');
    }

    public function fees(){
        return $this->hasMany('App\Fee');
    }

    public function studentSections(){
        return $this->hasMany('App\StudentSection');
    }
}
