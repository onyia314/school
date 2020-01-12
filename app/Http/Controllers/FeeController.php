<?php

namespace App\Http\Controllers;

use App\Fee;
use App\SchoolClass;
use App\SchoolSession;
use App\Semester;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FeeController extends Controller
{   
    private function validateFee($request){

        return $request->validate([
            'fee_name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'class_id' => 'required|integer|exists:classes,id',
            'section_id' => 'required|integer|exists:sections,id',
            'session_id' => 'required|integer|exists:sessions,id',
            'semester_id' => 'required|integer|exists:semesters,id',
        ]);
    }

    public function index($section_id , $semester_id){
        $section = Section::with('schoolClass')->findOrFail($section_id);
        $semester = Semester::with('schoolSession')->findOrFail($semester_id);
        $fees = Fee::where(['section_id'=> $section->id , 'semester_id' => $semester->id])->get();
        return view('fees.index')->with([
            'fees' => $fees ,
            'section' => $section , 
            'semester' => $semester,
         ]);
    }
    public function selectSectionAndSemester(){
        $schoolSessions = SchoolSession::with('semesters')->get();
        $schoolClasses = SchoolClass::with('sections')->get();
        return view('fees.selectsectionandsemester')->with(['schoolClasses' => $schoolClasses, 'schoolSessions' => $schoolSessions ]);
    }

    public function create($section_id , $semester_id){

        $semester = Semester::with('schoolSession')->findOrfail($semester_id);
        $section = Section::with('schoolClass')->findOrFail($section_id);

        return view('fees.addfee.addfee')->with([
            'semester' => $semester,
            'section' => $section,
            ]);
    }

    public function store(Request $request){
        $data = $this->validateFee($request);

        if(
            Fee::where(['fee_name' => $data['fee_name'] ,
            'section_id' => $data['section_id'] ,
            'semester_id' => $data['semester_id'] ])->count()
        ){
            return back()->with('feeExists');
        }
        Fee::create($data);
        return back()->with('feeAdded');
    }

}
