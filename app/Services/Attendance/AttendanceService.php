<?php

namespace App\Services\Attendance;

use Illuminate\Support\Facades\DB;
use App\Attendance;
use App\User;
use Carbon\Carbon;

class AttendanceService{

    public static function takeAttendance($request){
        /* set presentUsers as an empty array if there is no box checked, 
            because if all checkboxes are unchecked
           then the $request->present becomes null
        */
        $presentUsers = ( isset($request->present) ) ? $request->present : [] ;

        DB::transaction(function () use ($request , $presentUsers) {

            foreach($request->users as $user_id){

                if( in_array($user_id , $presentUsers) )
                {
                    Attendance::create([
                        'user_id' => $user_id,
                        'course_id' => $request->course_id,
                        'section_id'=> $request->section_id,
                        'semester_id' => $request->semester_id,
                        'takenBy_id' => $request->takenBy_id,
                        'status' =>  1,
                    ]);
                }
                else
                {
                    Attendance::create([
                        'user_id' => $user_id,
                        'course_id' => $request->course_id,
                        'section_id'=> $request->section_id,
                        'semester_id' => $request->semester_id,
                        'takenBy_id' => $request->takenBy_id,
                        'status' =>  0,
                    ]);
                }
            
            }

        });
        
    }

    public static function studentsDayAttCheck($section_id){
        return Attendance::where([ 
            'course_id' => null ,
            'section_id' => $section_id,
         ])->whereDate('created_at' , Carbon::today() )->count();
    }

    public static function staffsDayAttCheck(){
       return Attendance::where([ 
            'course_id' => null ,
            'section_id' => null,
         ])->whereDate('created_at' , Carbon::today() )->count();
    }

    //count how many times an active student was present for a course id
    public static function studentAttPresent($course_id , $semester_id , $student_id){
        return Attendance::where(['course_id' => $course_id ,'semester_id' => $semester_id , 'user_id' => $student_id , 'status' => 1 ])->count();
    }

    public static function studentAttAbsent($course_id , $semester_id , $student_id){
        return Attendance::where(['course_id' => $course_id , 'semester_id' => $semester_id , 'user_id' => $student_id , 'status' => 0 ])->count();
    }

    //count how many times an active student was present in a semester (general attendace)
    public static function studentGeneralAttPresent($semester_id , $section_id , $student_id){
        return Attendance::where(['course_id' => null , 'section_id' => $section_id , 'semester_id' => $semester_id , 'user_id' => $student_id , 'status' => 1 ])->count();
    }

    public static function studentGeneralAttAbsent($semester_id , $section_id , $student_id){
        return Attendance::where(['course_id' => null , 'section_id' => $section_id , 'semester_id' => $semester_id , 'user_id' => $student_id , 'status' => 0 ])->count();
    }

    //count how many times an active staff was present in a semester(general attendace)
    public static function staffAttPresent($semester_id , $staff_id){
        return Attendance::where(['course_id' => null , 'section_id' => null , 'semester_id' => $semester_id , 'user_id' => $staff_id , 'status' => 1 ])->count();
    }

    public static function staffAttAbsent($semester_id , $staff_id){
        return Attendance::where(['course_id' => null , 'section_id' => null , 'semester_id' => $semester_id , 'user_id' => $staff_id , 'status' => 0 ])->count();
    }

}