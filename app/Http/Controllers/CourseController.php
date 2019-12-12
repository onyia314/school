<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\Course\CourseService;
use App\SchoolSession;
use App\SchoolClass;
use App\Course;

class CourseController extends Controller
{
    public function index(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('courses.index')->with(['schoolClasses' => $schoolClasses, 'schoolSessions' => $schoolSessions ]);
    }

    public function addCourse( $class_id , $section_id , $session_id , $semester_id){
        $coursesMadeInSelectedSemester = Course::where(['section_id' => $section_id , 'semester_id' => $semester_id])->pluck('course_name');
        //take away any course that has been added for the selected semester from suggested courses.
        $suggestedCourses = CourseService::suggestCourses($class_id)->diff($coursesMadeInSelectedSemester); 
        return view('courses.addcourse')->with([ 'class_id' => $class_id, 'section_id' => $section_id , 'session_id' => $session_id, 'semester_id' => $semester_id , 'suggestedCourses' => $suggestedCourses, 'coursesMadeInSelectedSemester' => $coursesMadeInSelectedSemester]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all() , [
            'session_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'course_name' => [function($attribute, $value , $fail){

               if(!empty($value)){

                    //when the checkbox is not checked, it wont be present in the request array
                    //but the input type text is present regardless of the data type
                    if( count($value) == 1){
                        if(!$value[0]){
                            $fail('you must input at least one course name');
                        }
                        if( strlen($value[0]) > 50){
                            $fail('input must not exceed 50 char');
                        }
                    }else{
                        foreach($value as $arrayElement){
                            if(strlen($arrayElement) > 50){
                                $fail('input must not exceed 50 char'); 
                            }
                        }
                    }

               }else{
                    $fail($attribute);
               }

            }],
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        // take-off the null value if present (when the text input value is 'null')
        $data = array_filter($request->course_name , function($value){
            return ( $value === null ) ? false : true ;  
        });

        foreach($data as $value){

            //in case the user inputs existing course per class per semester
            Course::updateOrCreate(
                [ 'course_name' => $value , 'semester_id' => $request->semester_id , 'class_id' => $request->class_id , 'section_id' => $request->section_id , 'session_id' => $request->session_id ],
                
                [ 'course_name' => $value , 'semester_id' => $request->semester_id , 'class_id' => $request->class_id , 'section_id' => $request->section_id , 'session_id' => $request->session_id ]
            );
        }

         return back()->with('courseAdded');

    }
}
