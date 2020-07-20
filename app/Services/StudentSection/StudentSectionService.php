<?php

namespace App\Services\StudentSection;

use App\StudentSection;

class StudentSectionService{

    public static function createStudentSection($data){
        StudentSection::create([
        'student_id' => $data['id'] ,
        'semester_id' => $data['semester_id'] ,
        'section_id' => $data['section_id'] ,
        'status' => $data['status'],
        ]);
    }

    public static function updateStudentSection($data){
        StudentSection::where('student_id' , $data['id'])->update([
        'semester_id' => $data['semester_id'] ,
        'section_id' => $data['section_id'] ,
        ]);
    }

    // get the history of the student's section
    public static function getStudentSections($student_id){
        return StudentSection::where('student_id' , $student_id)->with([
            'student' , 
            'semester' => function($query){$query->with('schoolSession');},
            'section' => function($query){$query->with('schoolClass');},
        ])->get();
    }

    //this checks if student has been in a section in a given semester
    public static function hasStudentBeenInSection($student_id , $section_id , $semester_id){
        return StudentSection::where([
        'student_id' => $student_id , 
        'section_id' => $section_id , 
        'semester_id' => $semester_id ,
        ])->exists();
    }

    //check if a student is already in any section for a semester
    public static function isStudentAlreadyInAnySection($student_id , $semester_id){
        return StudentSection::where([
            'student_id' => $student_id , 
            'semester_id' => $semester_id ,
        ])->exists();
    }
}