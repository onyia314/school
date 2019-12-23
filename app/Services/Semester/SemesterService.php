<?php
namespace App\Services\Semester;

use App\Semester;

class SemesterService{

    /**
     *  note that more than one semesters cannot be current the same time
     *  however more than one semester can be open and closed (locked);
     */
    public static function (){

    }

    public static function setSemesterToCurrent($semester_id){
        Semester::where('id' , $semester_id)->update(['current' => 1 ]);
    }

    public static function unsetSemesterFromCurrent($semester_id){
        Semester::where('id' , $semester_id)->update(['current' => 0 ]);
    }

    public static function closeSemester($semester_id){
        Semester::where('id' , $semester_id)->update(['status' => 'closed' ]);
    }

    public static function openSemester($semester_id){
        Semester::where('id' , $semester_id)->update(['status' => 'open' ]);
    }

    public static function isSemesterClosed($semester_id){
        $semester = Semester::find($semester_id);
        return ($semester->status == 'closed') ? true : false;
    }

}