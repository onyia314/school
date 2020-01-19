<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    public function schoolClass(){
        return $this->belongsTo('App\SchoolClass' , 'class_id');
    }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function courses(){
        return $this->hasMany('App\Course');
    }
    
    public function fees(){
        return $this->hasMany('App\Fee');
    }
}
