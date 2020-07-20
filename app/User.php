<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass not assignable.
     *
     * @var array
     */

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function studentInfo(){
        return $this->hasOne('App\StudentInfo');
    }

    public function staffInfo(){
        return $this->hasOne('App\StaffInfo');
    }

    public function section(){
        return $this->belongsTo('App\Section');
    }

    public function payments(){
        return $this->hasMany('App\Payment' , 'student_id');
    }

    public function attendances(){
        return $this->belongsTo('App\Attendance');
    }

    public function studentSections(){
        return $this->hasMany('App\StudentSection' , 'student_id');
    }
}
