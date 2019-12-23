<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Section;
use App\SchoolClass;
use App\User;
use Session;
use App\Services\Attendance\AttendanceService;
use App\Services\Semester\SemesterService;

class AttendanceController extends Controller
{

    private function getStudentsSection($section_id){
        return Section::where('id' , $section_id)->has('users')->with([
            'schoolClass' ,
            'users' => function($query){
                    $query->where(['role' => 'student' , 'active' => 1]);
                 },
        ])->get();
    }

    public function selectSection(){
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('attendance.student.selectsection')->with(['schoolClasses' => $schoolClasses]);
    }

    //create form for course attendance
    public function createStudent($course_id , $section_id , $semester_id , $takenBy_id){

        // total attendace present and total attendance absent for a course_id keyed with the id of the student
        $attPresent = [];
        $attAbsent =[];

        $sections = $this->getStudentsSection($section_id);

        foreach($sections as $section){
            foreach($section->users as $student){
                $attPresent[$student->id] = AttendanceService::studentAttPresent($course_id , $semester_id ,  $student->id);
                $attAbsent[$student->id] = AttendanceService::studentAttAbsent($course_id , $semester_id ,  $student->id);
            }
        }

        return view('attendance.student.create')->with([ 
            'sections' => $sections , 
            'course_id' => $course_id ,
            'section_id' => $section_id , 
            'semester_id' => $semester_id ,
            'takenBy_id' => $takenBy_id, // who took the attendance
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
        ]);  
    }

    
    /**
     * note that general student and staff attendace can only be made once in a day
     */
    //create form for general student attendance
    public function createGeneralStudent($section_id , $semester_id , $takenBy_id){

        //check if general attendance has been taken for the day
        if( AttendanceService::studentsDayAttCheck($section_id) ){
            Session::flash('studentsDayAttTaken');
        }

        $attPresent = [];
        $attAbsent =[];
        $sections = $this->getStudentsSection($section_id);

        foreach($sections as $section){
            foreach($section->users as $student){
                $attPresent[$student->id] = AttendanceService::studentGeneralAttPresent($semester_id , $section_id ,  $student->id);
                $attAbsent[$student->id] = AttendanceService::studentGeneralAttAbsent($semester_id , $section_id , $student->id);
            }
        }

        return view('attendance.student.creategeneral')->with([ 
            'sections' => $sections , 
            'section_id' => $section_id , 
            'semester_id' => $semester_id ,
            'takenBy_id' => $takenBy_id, // who took the attendance
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
        ]);

    }

    //create form for general staff attendance
    public function createStaff($semester_id , $takenBy_id){

         //check if general attendance has been taken for the day
        if( AttendanceService::staffsDayAttCheck() ){
            Session::flash('staffsDayAttTaken');
        }

        // total attendace present and total attendance absent keyed with the id of the staff 
        $attPresent = [];
        $attAbsent =[];

        $staffs = User::where([ 
            ['role' , '!=' , 'student'], 
            ['role' , '!=' , 'master'],
            ['role' , '!=' , 'admin'],
            ['active' , 1], 
        ])->get(); 

        foreach($staffs as $staff){
            $attPresent[$staff->id] = AttendanceService::staffAttPresent($semester_id ,  $staff->id);
            $attAbsent[$staff->id] = AttendanceService::staffAttAbsent($semester_id ,  $staff->id);
        }

        return view('attendance.staff.create')->with([ 
            'staffs' => $staffs,
            'semester_id' => $semester_id ,
            'takenBy_id' => $takenBy_id, // who took the attendance
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
        ]);
        
    }




    public function storeCoursesAttendance(Request $request){

        if( SemesterService::isSemesterClosed($request->semester_id) ){
            return back()->with('semesterClosed');
        }

        AttendanceService::takeAttendance($request);
        return back()->with('attTaken'); 
    }

    public function storeGeneralStudentAttendance(Request $request){

        if( SemesterService::isSemesterClosed($request->semester_id) ){
            return back()->with('semesterClosed');
        }
        
        if( AttendanceService::studentsDayAttCheck($request->section_id) ){
            return back();
        }
        AttendanceService::takeAttendance($request);
        return back()->with('attTaken'); 
    }

    public function storeStaffAttendance(Request $request){

        if( SemesterService::isSemesterClosed($request->semester_id) ){
            return back()->with('semesterClosed');
        }

        if( AttendanceService::staffsDayAttCheck() ){
            return back();
        }

        AttendanceService::takeAttendance($request);
        return back()->with('attTaken'); 
    }

}
