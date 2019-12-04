<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SchoolSession;
use App\SchoolClass;
use App\Course;
use App\Semester;

class CourseController extends Controller
{
    public function index(){
        $schoolClasses = SchoolClass::all();
        return view('courses.index')->with('schoolClasses' , $schoolClasses);
    }

    private function suggestCourses($class_id){

        /**
         * course suggestion is based on all the courses registered for a class_id for all the semesters
         * of the latest session.
         */
        $latestSession = SchoolSession::orderBy('created_at' , 'desc')->first();
        $semestersOfLatestSession = Semester::where('session_id' , $latestSession->id)->get();
        $semesters = [];

        foreach( $semestersOfLatestSession as $semester){
            $semesters[] = $semester->id;
        }
         
        //some course name might appear more than once because of the multiple semesters, so use unique() to get rid of duplicates leaving just one
        return Course::whereIn('semester_id' , $semesters)->where(['class_id' => $class_id])->pluck('course_name')->unique();
    }

    public function addCourse($class_id){

        $suggestedCourses = $this->suggestCourses($class_id);
        $schoolSessions = SchoolSession::with('semesters')->get();
        return view('courses.addcourse')->with([ 'schoolSessions' => $schoolSessions, 'class_id' => $class_id, 'suggestedCourses' => $suggestedCourses, ]);
    }

    public function store(Request $request){

        $data = $request->validate([
            'course_name' => 'required|string|max:50',
            'semester_id' => 'required|integer',
            'class_id' => 'required|integer',
        ]);

        //check is course already exists for that a class in a particular semester
        $num = Course::where([
            'course_name' => $data['course_name'],
            'semester_id' => $data['semester_id'],
            'class_id' => $data['class_id'],
        ])->count();

        if($num == 0){

            try {
                Course::create($data);
                return back()->with('courseAdded');
            } catch (\exception $e) {
                Log::info($e->getMessage());
                return back()->with('courseNotAdded');
            }
        }else{
            return back()->with('courseExists');
        }

    }
}
