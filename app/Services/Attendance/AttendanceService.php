<?php

namespace App\Services\Attendance;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\CourseAttendance;
use App\StudentDailyAttendance;
use App\StaffAttendance;
use App\User;
use Carbon\Carbon;

class AttendanceService{

    public static function takeCourseAttendance($request){
        /* set presentUsers as an empty array if there is no box checked, 
        because if all checkboxes are unchecked
           then the $request->present becomes null
        */
        $presentStudents = ( isset($request->present) ) ? $request->present : [] ;
        $dataForPresent = collect( $request->except(['present' , 'students']) )->merge(['status' => 1 , 'teacher_id' => Auth::user()->id])->toArray();
        $dataForAbsent = collect( $request->except(['present' , 'students']) )->merge(['status' => 0 , 'teacher_id' => Auth::user()->id])->toArray();

        DB::transaction(function () use ($request , $dataForPresent , $dataForAbsent , $presentStudents) {

            foreach($request->students as $student_id){
                if( in_array($student_id , $presentStudents) ){
                    $dataForPresent['student_id'] = $student_id;
                    CourseAttendance::create($dataForPresent);
                }else{
                    $dataForAbsent['student_id'] = $student_id;
                    CourseAttendance::create($dataForAbsent);
                } 
            }
        });  
    }

    public static function takeStudentDailyAttendance($request){

        $presentStudents = ( isset($request->present) ) ? $request->present : [] ;
        $dataForPresent = collect( $request->except(['present' , 'students']) )->merge(['status' => 1 , 'takenBy_id' => Auth::user()->id])->toArray();
        $dataForAbsent = collect( $request->except(['present' , 'students']) )->merge(['status' => 0 , 'takenBy_id' => Auth::user()->id])->toArray();

        DB::transaction(function () use ($request , $dataForPresent , $dataForAbsent , $presentStudents) {

            foreach($request->students as $student_id){
                if( in_array($student_id , $presentStudents) ){
                    $dataForPresent['student_id'] = $student_id;
                    StudentDailyAttendance::create($dataForPresent);
                }else{
                    $dataForAbsent['student_id'] = $student_id;
                    StudentDailyAttendance::create($dataForAbsent);
                } 
            }
        });
    }

    public static function takeStaffAttendance($request){

        $presentStaffs = ( isset($request->present) ) ? $request->present : [] ;
        $dataForPresent = collect( $request->except(['present' , 'staffs']) )->merge(['status' => 1 , 'takenBy_id' => Auth::user()->id])->toArray();
        $dataForAbsent = collect( $request->except(['present' , 'staffs']) )->merge(['status' => 0 , 'takenBy_id' => Auth::user()->id])->toArray();

        DB::transaction(function () use ($request , $dataForPresent , $dataForAbsent , $presentStaffs) {

            foreach($request->staffs as $staff_id){
                if( in_array($staff_id , $presentStaffs) ){
                    $dataForPresent['user_id'] = $staff_id;
                    StaffAttendance::create($dataForPresent);
                }else{
                    $dataForAbsent['user_id'] = $staff_id;
                    StaffAttendance::create($dataForAbsent);
                } 
            }
        });
    }

    public static function studentsDailyAttCheck($section_id){
        return StudentDailyAttendance::where('section_id' , $section_id)
        ->whereDate('created_at' , Carbon::today() )->count();
    } 

    public static function staffsDailyAttCheck(){
       return StaffAttendance::whereDate('created_at' , Carbon::today() )->count();
    } 

    //count how many times an active student was present for a course id
    public static function studentAttPresent($course_id , $semester_id , $student_id){
        return  CourseAttendance::where(['course_id' => $course_id ,'semester_id' => $semester_id , 'student_id' => $student_id , 'status' => 1 ])->count();
    }

    public static function studentAttAbsent($course_id , $semester_id , $student_id){
        return  CourseAttendance::where(['course_id' => $course_id , 'semester_id' => $semester_id , 'student_id' => $student_id , 'status' => 0 ])->count();
    }

     //count how many times an active student was present in a semester (general attendace)
    public static function studentDailyAttPresent($semester_id , $section_id , $student_id){
        return StudentDailyAttendance::where(['section_id' => $section_id , 'semester_id' => $semester_id , 'student_id' => $student_id , 'status' => 1 ])->count();
    }

    public static function studentDailyAttAbsent($semester_id , $section_id , $student_id){
        return StudentDailyAttendance::where(['section_id' => $section_id , 'semester_id' => $semester_id , 'student_id' => $student_id , 'status' => 0 ])->count();
    } 

    //count how many times an active staff was present in a semester(general attendace)
    public static function staffAttPresent($semester_id , $staff_id){
        return StaffAttendance::where(['semester_id' => $semester_id , 'user_id' => $staff_id , 'status' => 1 ])->count();
    }

    public static function staffAttAbsent($semester_id , $staff_id){
        return StaffAttendance::where(['semester_id' => $semester_id , 'user_id' => $staff_id , 'status' => 0 ])->count();
    }

}