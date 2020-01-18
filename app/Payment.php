<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function fee(){
        return $this->belongsTo('App\Fee');
    }

    public function student(){
        return $this->belongsTo('App\User');
    }
}
