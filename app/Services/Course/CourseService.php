<?php
    namespace App\Services\Course;
    use App\SchoolSession;
    use App\Semester;
    use App\Course;

    class CourseService{

        private static function semestersOfLatestSession(){

            $semesters = [];
   
            $latestSession = SchoolSession::orderBy('created_at' , 'desc')->first();
            $semestersOfLatestSession = Semester::where('session_id' , $latestSession->id)->get();
   
            foreach( $semestersOfLatestSession as $semester){
               $semesters[] = $semester->id;
           }
   
           return $semesters;
       }



       private static function semestersOfPreviousSession(){

            $semesters = [];

            $previousSession = SchoolSession::orderBy('created_at' , 'desc')->skip(1)->first();

            $semestersOfPreviousSession = Semester::where('session_id' , $previousSession->id)->get();

            foreach( $semestersOfPreviousSession as $semester){
                $semesters[] = $semester->id;
            }
            return $semesters;
        }


        public static function suggestCourses($class_id){
        
            //check if at least a session session exists
            if( $numberOfSessions = SchoolSession::count() ){
           
               //if only one session exists then suggest courses based on the semester(s) of this session 
               if($numberOfSessions == 1){
                   return Course::whereIn('semester_id' , CourseService::semestersOfLatestSession() )->where(['class_id' => $class_id])->pluck('course_name')->unique();
               }
               else{ // more than one session
   
                   //get the latest session and suggest courses if and only if at least a semester of this session has course(s) 
                   if( Course::whereIn('semester_id' , CourseService::semestersOfLatestSession() )->where(['class_id' => $class_id])->exists() ){
                       //merge both semesterd of immediate previous session and semester of latest session 
                       $semesters = array_merge(CourseService::semestersOfLatestSession() , CourseService::semestersOfPreviousSession());
                       return Course::whereIn('semester_id' , $semesters)->where(['class_id' => $class_id])->pluck('course_name')->unique();
                   }else{
                       //if semester of the this latest session has no courses then suggest from previous session
                       return Course::whereIn('semester_id' , CourseService::semestersOfPreviousSession())->where(['class_id' => $class_id])->pluck('course_name')->unique();
                   }
               }
            }
            
            //if no sesssion exists use empty array of semester
           return Course::whereIn('semester_id' , [] )->where(['class_id' => $class_id])->pluck('course_name')->unique();
       }



    }
