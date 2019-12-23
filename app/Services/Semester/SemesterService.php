<?php
namespace App\Services\Semester;

use App\Semester;

class SemesterService{

    /**
     *  not that more than one semesters cannot be current the same time
     */
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

}