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
}
