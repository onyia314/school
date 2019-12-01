<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $guarded = [];

    public function semester(){
        return $this->belongsTo('App\Semester');
    }
    
}
