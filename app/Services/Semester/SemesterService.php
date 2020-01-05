<?php
namespace App\Services\Semester;

use App\Semester;
use Illuminate\Support\Facades\DB;

class SemesterService{

    public static function lockSemester($semester_id){
        Semester::where('id' , $semester_id)->update(['status' => 'closed' ]);
    }

    public static function openSemester($semester_id){
        Semester::where('id' , $semester_id)->update(['status' => 'open' ]);
    }
    
    /**
     * check if a semester is locked
     */
    public static function isSemesterLocked($semester_id){
        $semester = Semester::find($semester_id);
        return ($semester->status == 'locked') ? true : false;
    }

    //check if a given semester is ongoing
    public static function isSemesterCurrent($semester_id){
        return ($semester_id == self::getCurrentSemester() ) ? true : false;
    }

    /**
     * get the the current semester id if the time the script is running falls
     *  between the start_date and end_date
     * 
     * else return 0 as id 
     */
    public static function getCurrentSemester(){
        $currentSemester = DB::table('semesters')->select('*')
        ->where( DB::raw('now()') , '>=' , DB::raw('start_date') )
        ->where( DB::raw('now()') , '<=' , DB::raw('end_date') )->get();

        if( $currentSemester->count() ){
            return $currentSemester->first()->id;
        }

        return 0;
    }

    /** Check if semester belongs to session
     *  
     * make sure you have checked the existence of the parameters
     * of this method before using it,
     *  as u see we are not checking if $semester is null
     */
    public static function doesSemesterBelongToSession($semester_id , $session_id){
        $semester = Semester::with('schoolSession')->where('id' , $semester_id)->first();
        return $semester->session_id == $session_id ? true : false;
    }

}