<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\Course\CourseService;
use App\SchoolSession;
use App\SchoolClass;
use App\Course;
use App\User;

class CourseController extends Controller
{
    public function index(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('courses.index')->with(['schoolClasses' => $schoolClasses, 'schoolSessions' => $schoolSessions ]);
    }

    public function addCourse( $class_id , $section_id , $session_id , $semester_id ){
        $teachers = User::where('role' , 'teacher')->get();
        $coursesMadeInSelectedSemester = Course::where(['section_id' => $section_id , 'semester_id' => $semester_id])->get();
        //take away any course that has been added for the selected semester from suggested courses.
        $suggestedCourses = CourseService::suggestCourses($class_id)->diff( Course::whereIn('course_name' , $coursesMadeInSelectedSemester->pluck('course_name')->toArray() )->get() );
        return view('courses.addcourse')->with([ 'class_id' => $class_id, 'section_id' => $section_id , 'session_id' => $session_id, 'semester_id' => $semester_id , 'suggestedCourses' => $suggestedCourses, 'coursesMadeInSelectedSemester' => $coursesMadeInSelectedSemester , 'teachers' => $teachers ,]);
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
