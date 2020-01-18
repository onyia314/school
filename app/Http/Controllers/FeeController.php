<?php

namespace App\Http\Controllers;

use App\Fee;
use App\SchoolClass;
use App\SchoolSession;
use App\Semester;
use App\Section;
use App\Payment;
use App\Services\StudentSection\StudentSectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class FeeController extends Controller
{   
    private function validateFee($request){

        return $request->validate([
            'fee_id' => 'sometimes|required|integer|exists:fees,id',
            'fee_name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'section_id' => 'sometimes|required|integer|exists:sections,id',
            'semester_id' => 'sometimes|required|integer|exists:semesters,id',
        ]);
    }

    public function index($section_id , $semester_id){
       
        $section = Section::with('schoolClass')->findOrFail($section_id);
        $semester = Semester::with('schoolSession')->findOrFail($semester_id);

        //make sure the student views and pays for only fees of sections he has ever been
        //in a given academic session

        if(Auth::user()->role == 'student'){

            if( !StudentSectionService::hasStudentBeenInSection(
                 Auth::user()->id , $section_id , $semester->schoolSession->id) 
            )
            {
                abort(403 , 'you were never in this section in the session of the selected semester');
            }

            $fees = Fee::with([
                'payment' => function($query){ $query->where('student_id' , Auth::user()->id ); },
                ])
            ->where(['section_id'=> $section->id , 'semester_id' => $semester->id])->get();

            return view('fees.index')->with([
                'fees' => $fees ,
                'section' => $section , 
                'semester' => $semester,
            ]);

        }

        $fees = Fee::where(['section_id'=> $section->id , 'semester_id' => $semester->id])->get();
        return view('fees.index')->with([
            'fees' => $fees ,
            'section' => $section , 
            'semester' => $semester,
         ]);
    }

    public function studentSections(){
        $studentSections = StudentSectionService::getStudentSections(Auth::user()->id);
        $sections = Section::whereIn( 'id' , $studentSections->pluck('section_id')->toArray() )
                            ->with('schoolClass')->get();
        $schoolSessions = SchoolSession::whereIn( 'id' , $studentSections->pluck('session_id')->toArray() )
                            ->with('semesters')->get();
        return view('fees.student.selectsectionandsemester')->with([ 
            'sections' => $sections ,
            'schoolSessions' => $schoolSessions,
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

    public function edit($fee_id){
        $fee = Fee::findOrFail($fee_id);
        return view('fees.edit' , ['fee' => $fee] );
    }

    public function store(Request $request){

        $data = $this->validateFee($request);

        $section = Section::with('schoolClass')->find( $data['section_id']);
        $semester = Semester::with('schoolSession')->find($data['semester_id']);

        $data['class_id'] = $section->schoolClass->id;
        $data['session_id'] = $semester->schoolSession->id;

        //check if fee name exists in the section for that semester
        if(
            Fee::where(['fee_name' => $data['fee_name'] ,
            'section_id' => $data['section_id'] ,
            'semester_id' => $data['semester_id'] ])->count()
        ){
            return back()->with('feeNameExists');
        }

        try {
            Fee::create($data);
            return back()->with('feeAdded');
        } catch (\Exception $e) {
            Log::info('error adding fee : ' .$e->getMessage());
            return back()->with('feeNotAdded');
        }
        
    }

    public function update(Request $request){
        $data = $this->validateFee($request);
        $fee = Fee::findOrFail($request->fee_id);

        //check if fee name exists for other fee ids in the section in that semester
        if(
            Fee::where([

            [ 'id' , '!=' , $data['fee_id'] ] ,
            [ 'fee_name' , $data['fee_name'] ] ,
            [ 'section_id' , $fee->section_id ] ,
            [ 'semester_id' , $fee->semester_id ],

            ])->count()
        ){
            return back()->with('feeNameExists');
        }

        try {
            Fee::where('id' , $fee->id)->update([ 'fee_name' => $data['fee_name'] , 'amount' => $data['amount'] ]);
            return back()->with('feeUpdated');
        } catch (\Exception $e) {
            Log::info('fee not updated : ' .$e->getmessage() );
            return back()->with('feeNotUpdated');
        }
    }

}
