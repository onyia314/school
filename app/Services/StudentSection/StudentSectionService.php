<?php

namespace App\Services\StudentSection;

use App\StudentSection;

class StudentSectionService{

    public static function createStudentSection($data){
        StudentSection::create([
        'student_id' => $data['id'] ,
        'session_id' => $data['session_id'] ,
        'section_id' => $data['section_id'] ,
        ]);
    }

    public static function updateStudentSection($data){
        StudentSection::where('student_id' , $data['id'])->update([
        'session_id' => $data['session_id'] ,
        'section_id' => $data['section_id'] ,
        ]);
    }

    public static function getStudentSections($student_id){
        return StudentSection::where('student_id' , $student_id)->get();
    }

    public static function hasStudentBeenInSection($student_id , $section_id , $session_id){
        return StudentSection::where([
        'student_id' => $student_id , 
        'section_id' => $section_id , 
        'session_id' => $session_id ,
        ])->exists();
    }
}