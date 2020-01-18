<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $guarded = [];

    public function semester(){
        return $this->belongsTo('App\Semester');
    }

    public function section(){
        return $this->belongsTo('App\Section');
    }

    public function payments(){
        return $this->hasMany('App\Payment');
    }
    
}
