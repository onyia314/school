<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\CourseService;
use App\Services\Semester\SemesterService;
use App\Services\Section\SectionService;
use App\SchoolSession;
use App\SchoolClass;
use App\Section;
use App\Semester;
use App\Course;
use App\User;

class CourseController extends Controller
{
    public function indexTeacher(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        return view('courses.selectsemester')->with( [ 'schoolSessions' => $schoolSessions ] );
    }

    public function teacherCourses($semester_id){
        $courses = Course::where( [ 'semester_id' => $semester_id , 'teacher_id' => Auth::user()->id ])->with( [ 'schoolClass' , 'section' ] )->get();
        return view('courses.index')->with(['courses' => $courses]);
    }

    public function studentCourses(){
        $courses = Course::where([ 
        'section_id' => Auth::user()->section_id,
        'semester_id' => SemesterService::getCurrentSemesterId(),
        ])->with(['teacher' , 'schoolClass' , 'section'])->get();
        return view('courses.index')->with(['courses' => $courses]);
    }

    public function indexToSemester(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('courses.addcourse.indextosemester')->with(['schoolClasses' => $schoolClasses, 'schoolSessions' => $schoolSessions ]);
    }

    public function addCourse( $section_id , $semester_id ){

        $semester = Semester::with('schoolSession')->findOrFail($semester_id);
        $section = Section::with('schoolClass')->findOrFail($section_id);

        $teachers = User::where(['role' => 'teacher', 'active' => 1 ])->get();
        $coursesMadeInSelectedSemester = Course::where(['section_id' => $section_id , 'semester_id' => $semester_id])->get();
        //take away any course that has been added for the section in the selected semester from suggested courses.
        $suggestedCourses = CourseService::suggestCourses($section->class_id)->diff( Course::whereIn('course_name' , $coursesMadeInSelectedSemester->pluck('course_name')->toArray() )->get() );
        return view('courses.addcourse.addcourse')->with([ 
            'class_id' => $section->class_id, 
            'section_id' => $section_id , 
            'session_id' => $semester->session_id, 
            'semester_id' => $semester_id , 
            'suggestedCourses' => $suggestedCourses,
            'coursesMadeInSelectedSemester' => $coursesMadeInSelectedSemester , 
            'teachers' => $teachers ,
            ]);
    }

    public function store(Request $request){

        $data = $request->validate([
            'session_id' => 'required|integer|exists:sessions,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'class_id' => 'required|integer|exists:classes,id',
            'section_id' => 'required|integer|exists:sections,id',
            'course_name' => 'required|string|max:100',
            'course_type' => 'required|string|max:50',
            'course_time' => 'required|string|max:100',
            'teacher_id' => 'required|integer|exists:users,id',
        ]);
        
        $num = Course::where( [ 'course_name' => $data['course_name'] , 'section_id' => $data['section_id'] , 'semester_id' => $data['semester_id'] ] )->count();
        
        if($num){
            return back()->with('courseExists');
        }

        if( !SemesterService::doesSemesterBelongToSession($request->semester_id , $request->session_id) 
            || !SectionService::doesSectionBelongToClass($request->section_id , $request->class_id) )
        {
            return back()->with('invalidRelationShip');
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
