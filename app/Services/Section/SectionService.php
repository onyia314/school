<?php
namespace App\Services\Section;
use App\Section;


class SectionService{

    public static function sectionExists($section_id){
        return Section::where('id' , $section_id)->count();
    }

    /** Check if semction belongs to class
     *  
     * make sure you have checked the existence of the parameters
     * of this method before using it,
     *  as u see we are not checking if $section is null
     */
    public static function doesSectionBelongToClass($section_id , $class_id){
        $section  = Section::with('schoolClass')->where('id' , $section_id)->first();
        return $section->class_id == $class_id ? true : false;
    }

    public static function getSectionStudents($section_id){
        return Section::where('id' , $section_id)->has('users')->with([
            'schoolClass' ,
            'users' => function($query){
                    $query->where(['role' => 'student' , 'active' => 1]);
                 },
        ])->get();
    }
}