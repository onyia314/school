<?php
    namespace App\Services\Course;
    use App\SchoolSession;
    use App\Semester;
    use App\Course;

    class CourseService{

        private static function semestersOfLatestSession(){
            $latestSession = SchoolSession::orderBy('created_at' , 'desc')->first();
            return Semester::where('session_id' , $latestSession->id)->pluck('id')->toArray();
        }

       private static function semestersOfPreviousSession(){
            $previousSession = SchoolSession::orderBy('created_at' , 'desc')->skip(1)->first();
            return Semester::where('session_id' , $previousSession->id)->pluck('id')->toArray();
        }


        public static function suggestCourses($class_id){
        
            //check if at least a session session exists
            if( $numberOfSessions = SchoolSession::count() ){
           
               //if only one session exists then suggest courses based on the semester(s) of this session 
               if($numberOfSessions == 1){
                   return Course::whereIn('semester_id' , CourseService::semestersOfLatestSession() )->where(['class_id' => $class_id])->get()->unique('course_name');
               }
               else{ // more than one session
   
                   //if at least a semester of latest session has course(s) 
                   if( Course::whereIn('semester_id' , CourseService::semestersOfLatestSession() )->where(['class_id' => $class_id])->exists() ){
                       //merge both semesters of immediate previous session and semesters of latest session 
                       $semesters = array_merge(CourseService::semestersOfLatestSession() , CourseService::semestersOfPreviousSession());
                       return Course::whereIn('semester_id' , $semesters)->where(['class_id' => $class_id])->get()->unique('course_name');
                   }else{
                       //if semester of the this latest session has no courses then suggest from previous session
                       return Course::whereIn('semester_id' , CourseService::semestersOfPreviousSession())->where(['class_id' => $class_id])->get()->unique('course_name');
                   }
               }
            }
            
            //if no sesssion exists use empty array of semester
           return Course::whereIn('semester_id' , [] )->where(['class_id' => $class_id])->get()->unique('course_name');
       }

       public static function doesCourseBelongToSemester($course_id , $semester_id){
            return Course::where(['id' => $course_id , 'semester_id' => $semester_id])->count();
       }

       public static function doesCourseBelongToSection($course_id , $section_id){
            return Course::where(['id' => $course_id , 'section_id' => $section_id])->count();
       }

       public static function doesCourseBelongToTeacher($course_id , $teacher_id){
            return Course::where(['id' => $course_id , 'teacher_id' => $teacher_id])->count();
       }


    }
