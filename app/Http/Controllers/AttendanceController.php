<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Services\Attendance\AttendanceService;
use App\Services\Semester\SemesterService;
use App\Services\Section\SectionService;
use App\Services\Course\CourseService;
use App\Section;
use App\SchoolClass;
use App\User;
use Session;
use DateTime;

class AttendanceController extends Controller
{
    public function validateAttendanceInput($request){
        /**
         * we also check the existance of a course,section,user, here
         */
        $request->validate([
            'semester_id' => 'required|integer|exists:semesters,id',
            'section_id' => 'sometimes|required|integer|exists:sections,id',
            'course_id' => 'sometimes|required|integer|exists:courses,id',
            'students.*' => 'sometimes|required|exists:users,id',
            'staffs.*' => 'sometimes|required|exists:users,id',
        ]);
    }
    private function getStudentsSection($section_id){
        return Section::where('id' , $section_id)->has('users')->with([
            'schoolClass' ,
            'users' => function($query){
                    $query->where(['role' => 'student' , 'active' => 1]);
                 },
        ])->get();
    }

    //to select the section for student daily attendance
    public function selectSection(){
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('attendance.student.selectsection')->with(['schoolClasses' => $schoolClasses]);
    }

    //create form for course attendance
    public function createStudent($course_id , $section_id , $semester_id){

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
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
        ]);  
    }

    
    /**
     * note that general student and staff attendace can only be made once in a day
     */
    //create form for general student attendance
    public function createDailyStudent($section_id){
        
        if( !SectionService::sectionExists($section_id) ){
            Session::flash('sectionDoesNotExist');
        }
        //check if general attendance has been taken for the day
        if( AttendanceService::studentsDailyAttCheck($section_id) ){
            Session::flash('studentsDailyAttTaken' , $section_id);
        }

        $attPresent = [];
        $attAbsent =[];
        $sections = $this->getStudentsSection($section_id);
        //admin does not explicitly select semester for student daily attendance,
        // we use current time to match the the start_date
        //and end_date of the semester
        $semester_id = SemesterService::getCurrentSemester();

        foreach($sections as $section){
            foreach($section->users as $student){
                $attPresent[$student->id] = AttendanceService::studentDailyAttPresent($semester_id , $section_id ,  $student->id);
                $attAbsent[$student->id] = AttendanceService::studentDailyAttAbsent($semester_id , $section_id , $student->id);
            }
        }

        return view('attendance.student.createdaily')->with([ 
            'sections' => $sections , 
            'section_id' => $section_id , 
            'semester_id' => $semester_id ,
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
        ]);

    }

    //create form for staff attendance
    public function createStaff(){

        //check if attendance has been taken for the day
        if( AttendanceService::staffsDailyAttCheck() ){
            Session::flash('staffsDailyAttTaken');
        }

        // total attendace present and total attendance absent keyed with the id of the staff 
        $attPresent = [];
        $attAbsent =[];
        $semester_id = SemesterService::getCurrentSemester();

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
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
        ]);
        
    }

    public function storeCoursesAttendance(Request $request){

        $this->validateAttendanceInput($request);

        if( SemesterService::isSemesterCurrent($request->semester_id) ){

            if( SemesterService::isSemesterLocked($request->semester_id) ){
                return back()->with('semesterLocked');
            }

            if( !CourseService::doesCourseBelongToSemester($request->course_id , $request->semester_id) ){
                return back()->with('courseDoesNotBelongToSemester');
            }

            if( !CourseService::doesCourseBelongToSection($request->course_id , $request->section_id) ){
                return back()->with('courseDoesNotBelongToSection');
            }

            if( !CourseService::doesCourseBelongToTeacher($request->course_id , Auth::user()->id ) ){
                return back()->with('courseDoesNotBelongToTeacher');
            }

            AttendanceService::takeCourseAttendance($request);
            return back()->with('attTaken');
        }

        return back()->with('semesterNotCurrent');
    }

    public function storeDailyAttendance(Request $request){
       
        $this->validateAttendanceInput($request);

        if( SemesterService::isSemesterCurrent($request->semester_id) ){

            if( SemesterService::isSemesterLocked($request->semester_id) ){
                return back()->with('semesterLocked');
            }
            //check if attendance has been taken today
            if( AttendanceService::studentsDailyAttCheck($request->section_id) ){
                return back(); //the msg is already shown when creating the form
            }
            AttendanceService::takeStudentDailyAttendance($request);
            return back()->with('attTaken'); 
        }
        
        return back()->with('semesterNotCurrent');   
    }

    public function storeStaffAttendance(Request $request){

        $this->validateAttendanceInput($request);

        if( SemesterService::isSemesterCurrent($request->semester_id) ){

            if( SemesterService::isSemesterLocked($request->semester_id) ){
                return back()->with('semesterLocked');
            }
            if( AttendanceService::staffsDailyAttCheck() ){
                return back();
            }
        }
        AttendanceService::takeStaffAttendance($request);
        return back()->with('attTaken'); 
    }

}
