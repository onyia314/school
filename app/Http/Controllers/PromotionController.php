<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\schoolClass;
use App\schoolSession;
use App\User;
use App\StudentSection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\StudentSection\StudentSectionService;
use App\Services\Semester\SemesterService;

class PromotionController extends Controller
{
    private function validateData($request){
        
        return Validator::make( $request->all() , [
            'current_section_id' => 'required|integer|exists:sections,id',
            'section_id' => 'nullable|required_if:status,promoted,demoted|integer|exists:sections,id',
            'semester_id' => 'nullable|required_if:status,promoted,demoted,repeat|integer|exists:semesters,id',
            'students' => 'required|min:1|array',
            'status' => 'required|string|in:promoted,demoted,repeat,left,graduated',
            'students.*' => ['integer','exists:users,id', function($attribute , $value , $fail) use ($request){
                //a student should not belong to more than one section in a given semester
                if(StudentSectionService::isStudentAlreadyInAnySection($value , $request->semester_id)){
                    $fail('student with an id of ' .$value .' already belongs to a section in the selected semester');
                }
            }],
        ]);
    }

    private function getSectionStudentsForSemester($section_id , $semester_id){
        return User::where([
            'section_id' => $section_id , 
            'semester_id' => $semester_id , 
            'role' => 'student' ,
            'active' => 1]);
    }

    public function create($section_id){

        $currentSemester_id = SemesterService::getCurrentSemesterId();

        if(!$currentSemester_id){
            abort(403 , 'invalid semester');
        }
        
        $schoolClasses = SchoolClass::has('sections')->with('sections')->get();
        $schoolSessions = SchoolSession::with('semesters')->get();
        $students = $this->getSectionStudentsForSemester( 
            $section_id , $currentSemester_id 
        )->paginate(25);
        return view('promotion.create' , 
        ['students' => $students , 'schoolClasses' => $schoolClasses , 'currentSectionId' => $section_id , 
        'schoolSessions' => $schoolSessions]);
    }

    private function promoteStudents(array $students , $current_section_id , $section_id , $semester_id , $status){
        
        DB::beginTransaction();
        try {

            foreach ($students as $student_id) {
                $data = [];
                $data['id'] = $student_id;
                $data['section_id'] = $section_id;
                $data['semester_id'] = $semester_id;
                $data['status'] = $status;
                StudentSectionService::createStudentSection($data);
                User::where('id' , $student_id)
                ->update(['section_id' => $data['section_id'] , 'semester_id' => $data['semester_id'] ]);
            }
            DB::commit();
            return Redirect::route('promote.students.create' , ['section_id' => $current_section_id]);
            //dd('students promoted');

        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e->getMessage() );
            dd('not working');
        }
    }

    private function leftOrGraduated(array $students , $status ){
        // update the student_sections table and deactivate the user
        DB::beginTransaction();
        try {

            foreach ($students as $student_id) {
                StudentSection::where('student_id' , $student_id)->update(['status' => $status]);
                User::where('id' , $student_id)
                ->update(['section_id' => null , 'semester_id' => null , 'active' => '0' ]);
            }
            DB::commit();
            dd('ok');

        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e->getMessage() );
            dd('not ok');
        }
    }


    public function store(Request $request){
        
        $validator = $this->validateData($request);

        if( $validator->fails() ){
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        $validatedData = $validator->valid();
        
        $students = $validatedData['students'];
        $current_section_id = $validatedData['current_section_id'];
        $section_id = $validatedData['section_id'];
        $semester_id = $validatedData['semester_id'];
        $status = $validatedData['status'];

        switch ($validatedData['status']) {
            case 'promoted':
            case 'demoted' : 
               $this->promoteStudents($students ,$current_section_id , $section_id , $semester_id , $status);
                break;
            case 'repeat':
                $this->promoteStudents($students , $current_section_id , $semester_id , $status);
                break;
            case 'left':
            case 'graduated':
                $this->leftOrGraduated($students , $status, $current_section_id);
                break;
        }
    }
}
