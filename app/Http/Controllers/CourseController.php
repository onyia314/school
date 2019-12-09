<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\SchoolSession;
use App\SchoolClass;
use App\Course;
use App\Semester;

class CourseController extends Controller
{
    public function index(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        $schoolClasses = SchoolClass::all();
        return view('courses.index')->with(['schoolClasses' => $schoolClasses, 'schoolSessions' => $schoolSessions ]);
    }

    private function semestersOfLatestSession(){

         $semesters = [];

         $latestSession = SchoolSession::orderBy('created_at' , 'desc')->first();
         $semestersOfLatestSession = Semester::where('session_id' , $latestSession->id)->get();

         foreach( $semestersOfLatestSession as $semester){
            $semesters[] = $semester->id;
        }

        return $semesters;
    }

    private function semestersOfPreviousSession(){

        $semesters = [];

        $previousSession = SchoolSession::orderBy('created_at' , 'desc')->skip(1)->first();

        $semestersOfPreviousSession = Semester::where('session_id' , $previousSession->id)->get();

        foreach( $semestersOfPreviousSession as $semester){
            $semesters[] = $semester->id;
        }
        return $semesters;
    }

    private function suggestCourses($class_id){
        
         //check if at least a session session exists
         if( $numberOfSessions = SchoolSession::count() ){
        
            //if only one session exists then suggest courses based on the semester(s) of this session 
            if($numberOfSessions == 1){
                return Course::whereIn('semester_id' , $this->semestersOfLatestSession() )->where(['class_id' => $class_id])->pluck('course_name')->unique();
            }
            else{ // more than one session

                //get the latest session and suggest courses if and only if at least a semester of this session has course(s) 
                if( Course::whereIn('semester_id' , $this->semestersOfLatestSession() )->where(['class_id' => $class_id])->exists() ){
                    //merge both semesterd of immediate previous session and semester of latest session 
                    $semesters = array_merge($this->semestersOfLatestSession() , $this->semestersOfPreviousSession());
                    return Course::whereIn('semester_id' , $semesters)->where(['class_id' => $class_id])->pluck('course_name')->unique();
                }else{
                    //if semester of the this latest session has no courses then suggest from previous session
                    return Course::whereIn('semester_id' , $this->semestersOfPreviousSession())->where(['class_id' => $class_id])->pluck('course_name')->unique();
                }
            }
         }
         
         //if no sesssion exists use empty array of semester
        return Course::whereIn('semester_id' , [] )->where(['class_id' => $class_id])->pluck('course_name')->unique();
    }

    public function addCourse( $session_id , $class_id , $semester_id){
        $coursesMadeInSelectedSemester = Course::where(['class_id' => $class_id , 'semester_id' => $semester_id])->pluck('course_name');
        //take away any course that has been added for the selected semester from suggested courses.
        $suggestedCourses = $this->suggestCourses($class_id)->diff($coursesMadeInSelectedSemester); 
        return view('courses.addcourse')->with([ 'class_id' => $class_id, 'semester_id' => $semester_id , 'suggestedCourses' => $suggestedCourses, 'coursesMadeInSelectedSemester' => $coursesMadeInSelectedSemester]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all() , [
            'semester_id' => 'required|integer',
            'class_id' => 'required|integer',
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
                [ 'course_name' => $value , 'semester_id' => $request->semester_id , 'class_id' => $request->class_id ],
                
                [ 'course_name' => $value , 'semester_id' => $request->semester_id , 'class_id' => $request->class_id ]
            );
        }

         return back()->with('courseAdded');

    }
}
