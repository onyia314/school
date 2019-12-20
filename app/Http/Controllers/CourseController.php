<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Course\CourseService;
use App\SchoolSession;
use App\SchoolClass;
use App\Course;
use App\User;

class CourseController extends Controller
{
    public function indexTeacher(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        return view('courses.selectsemester')->with( [ 'schoolSessions' => $schoolSessions ] );
    }

    public function indexStudent(){
        /**
         * here the current school session is assumed to be the latest session created
         * this is a temporal feature, current school session should be stated explicitly
         * by the admin
         * 
         * so remember to add this current session functionality for the admin
         *                      AND
         * change the way current session is queried
         * 
         */
        $currentSession = SchoolSession::with('semesters')->orderBy('created_at' , 'desc')->first();
        return view('courses.selectsemester')->with( [ 'currentSession' => $currentSession ] );
    }

    public function teacherCourses($semester_id , $teacher_id){
        $courses = Course::where( [ 'semester_id' => $semester_id , 'teacher_id' => $teacher_id ])->with( [ 'schoolClass' , 'section' ] )->get();
        return view('courses.index')->with(['courses' => $courses]);
    }

    public function studentCourses($section_id , $semester_id){
        $courses = Course::where( [ 'section_id' => $section_id , 'semester_id' => $semester_id])->with('teacher')->get();
        return view('courses.index')->with(['courses' => $courses]);
    }

    public function indexToSemester(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('courses.addcourse.indextosemester')->with(['schoolClasses' => $schoolClasses, 'schoolSessions' => $schoolSessions ]);
    }

    public function addCourse( $class_id , $section_id , $session_id , $semester_id ){
        $teachers = User::where('role' , 'teacher')->get();
        $coursesMadeInSelectedSemester = Course::where(['section_id' => $section_id , 'semester_id' => $semester_id])->get();
        //take away any course that has been added for the section in the selected semester from suggested courses.
        $suggestedCourses = CourseService::suggestCourses($class_id)->diff( Course::whereIn('course_name' , $coursesMadeInSelectedSemester->pluck('course_name')->toArray() )->get() );
        return view('courses.addcourse.addcourse')->with([ 'class_id' => $class_id, 'section_id' => $section_id , 'session_id' => $session_id, 'semester_id' => $semester_id , 'suggestedCourses' => $suggestedCourses, 'coursesMadeInSelectedSemester' => $coursesMadeInSelectedSemester , 'teachers' => $teachers ,]);
    }

    public function store(Request $request){

        $data = $request->validate([
            'session_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'course_name' => 'required|string|max:100',
            'course_type' => 'required|string|max:50',
            'course_time' => 'required|string|max:100',
            'teacher_id' => 'required|integer',
        ]);
        
        $num = Course::where( [ 'course_name' => $data['course_name'] , 'section_id' => $data['section_id'] , 'semester_id' => $data['semester_id'] ] )->count();
        
        if($num){
            return back()->with('courseExists');
        }

        try {
            Course::create($data);
            return back()->with('courseAdded');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return back()->with('courseNotAdded');
        }

    }
}
