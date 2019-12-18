<?php

namespace App\Services\Attendance;

use Illuminate\Support\Facades\DB;
use App\Attendance;
use App\User;

class AttendanceService{

    public static function takeAttendance($request){
        /* set presentStudent as an empty array if there is no box checked, 
            because if all checkboxes are unchecked
           then the $request->present becomes null
        */
        $presentStudents = ( isset($request->present) ) ? $request->present : [] ;

        DB::transaction(function () use ($request , $presentStudents) {

            foreach($request->students as $student_id){

                if( in_array($student_id , $presentStudents) )
                {
                    Attendance::create([
                        'student_id' => $student_id,
                        'course_id' => $request->course_id,
                        'section_id'=> $request->section_id,
                        'semester_id' => $request->semester_id,
                        'user_id' => $request->user_id,
                        'status' =>  1,
                    ]);
                }
                else
                {
                    Attendance::create([
                        'student_id' => $student_id,
                        'course_id' => $request->course_id,
                        'section_id'=> $request->section_id,
                        'semester_id' => $request->semester_id,
                        'user_id' => $request->user_id,
                        'status' =>  0,
                    ]);
                }
            
            }

        });
        
    }

    public static function totalCourseAttPerSemester($course_id , $semester_id , $section_id){
        /**
         * even though course_id is assigned to a particular teacher
         * admin can take attendance for the course 
         * so total attendance inludes ones taken by the course teacher and the admin conbined 
         * 
         */
        $totalStudentsInSection = User::where('section_id' , $section_id)->count();

        //to avoid error due to division by zero
        if( $totalStudentsInSection == 0){
            return 0;
        }

        return Attendance::where([
            'course_id' => $course_id ,
            'section_id' => $section_id ,
            'semester_id' => $semester_id
        ])->count() / $totalStudentsInSection;
    }

    public static function individualAttPresent($course_id , $semester_id , $student_id){
        return Attendance::where(['course_id' => $course_id ,'semester_id' => $semester_id , 'student_id' => $student_id , 'status' => 1 ])->count();
    }

    public static function individualAttAbsent($course_id , $semester_id , $student_id){
        return Attendance::where(['course_id' => $course_id , 'semester_id' => $semester_id , 'student_id' => $student_id , 'status' => 0 ])->count();
    }

}