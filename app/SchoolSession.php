<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    protected $table = 'sessions';
    protected $guarded = [];

    public function semesters(){
        return $this->hasMany('App\Semester' , 'session_id');
    }
}
