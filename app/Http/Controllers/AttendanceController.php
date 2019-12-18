<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Services\Attendance\AttendanceService;

class AttendanceController extends Controller
{
    public function create($course_id , $section_id , $semester_id , $user_id){
        
        $attPresent = [];
        $attAbsent =[];
        $totalAtt = AttendanceService::totalCourseAttPerSemester($course_id , $semester_id , $section_id);

        $sections = Section::where('id' , $section_id)->has('users')->with(['users', 'schoolClass'])->get();
    
        foreach($sections as $section){
            foreach($section->users as $student){
                $attPresent[$student->id] = AttendanceService::individualAttPresent($course_id , $semester_id ,  $student->id);
                $attAbsent[$student->id] = AttendanceService::individualAttAbsent($course_id , $semester_id ,  $student->id);
            }
        }

        return view('attendance.create')->with([ 
            'sections' => $sections , 
            'course_id' => $course_id ,
            'section_id' => $section_id , 
            'semester_id' => $semester_id ,
            'user_id' => $user_id,
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
            'totalAtt' => $totalAtt,
        ]);  
    }

    public function store(Request $request){
        /**
         * attendedace is taken per course_id per semester_id
         */
        AttendanceService::takeAttendance($request);
        return back()->with('attTaken');
    }

}
