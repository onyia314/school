<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = "classes";

    protected $guarded = [];

    public function sections(){
        return $this->hasMany('App\Section' , 'class_id');
    }

    public function courses(){
        return $this->hasMany('App\Course' , 'class_id');
    }
}
