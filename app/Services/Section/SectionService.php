<?php
namespace App\Services\Section;
use App\Section;


class SectionService{

    public static function sectionExists($section_id){
        return Section::where('id' , $section_id)->count();
    }
}