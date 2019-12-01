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
}
