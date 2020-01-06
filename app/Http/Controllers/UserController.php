<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Section;
use App\SchoolSession;

class UserController extends Controller
{

    //this is used for updating
    private function putId($request){
        return ($request->id) ? ',' .$request->id : ''; 
    }

    public function validateStudent($request){

        return $request->validate([
            'id' => 'sometimes|required|integer|exists:users', //for editing user 
            'name' => 'required|string|max:255',
            'password' => 'sometimes|required|string|min:6|confirmed',
            'email' => ['nullable','string','email','max:255' , 'unique:users,email' .$this->putId($request)],
            'phone_number' => ['nullable','string','max:50','unique:users,phone_number' .$this->putId($request)],
            'birthday' => 'required|date',
            'nationality' => 'required|string|max:100',
            'state_of_origin' => 'required|string|max:100',
            'gender' => 'required|in:male,female',
            'religion' => 'required|string',
            'address' => 'required|string|max:225',
            'section_id' => 'required|integer|exists:sections,id',
            'session_id' => 'required|integer|exists:sessions,id',
            'father_name' => 'required|string|max:255',
            'father_phone' => '|nullable|required_without:mother_phone|string|max:50',
            'mother_name' => 'required|string|max:255',
            'mother_phone' => 'nullable|required_without:father_phone|string|max:50',
            'image' => 'file|image|max:5036',
        ]);

    }

    public function validateStaff($request){

        return $request->validate([
            'id' => 'sometimes|required|integer|exists:users', //for editing user 
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255' , 'unique:users,email' .$this->putId($request)],
            'phone_number' => ['required','string','max:50','unique:users,phone_number' .$this->putId($request)],
            'password' => 'sometimes|required|string|min:6|confirmed',
            'birthday' => 'required|date',
            'nationality' => 'required|string|max:100',
            'state_of_origin' => 'required|string|max:100',
            'address' => 'required|string|max:225',
            'gender' => 'required|string',
            'religion' => 'required|string',
            'qualification' => 'required|string|max:100',
            'next_of_kin' => 'required|string|max:225',
            'next_of_kin_phone' => 'required|string|max:50',
            'referee' => 'required|string|max:255',
            'referee_phone' => 'required|string|max:50',
            'previous' => 'required|string|max:225',
            'image' => 'file|image|max:5036',
        ]);

    }

    protected function uploadUserImage($request){
        //check existence of file,upload and get the path
        return $path = $request->hasFile('image') ? $request->image->store('uploads' , 'public') : '';
    }

    public function storeStudent(Request $request){
        $data = $this->validateStudent($request);
        DB::beginTransaction();

        try {
                //upload the image and store the path
                $data['image'] = $this->uploadUserImage($request);
                $userCreated = UserService::storeStudent($data);
                //remove basic user info from the $data array
                unset(
                    $data['name'] ,
                    $data['email'] ,
                    $data['password'] ,
                    $data['phone_number'] , 
                    $data['image'] ,
                    $data['section_id']
                );
                //add additional info that StudentInfo model needs which are not present in the $request object
                $data['id'] = $userCreated->id;
                UserService::updateStudentInfo($data);
                DB::commit();
                return back()->with('userRegistered');

            }catch (\Exception $e) {
                Log::info( $e->getMessage() );
                //delete the uploaded image (if present ) if the user record was not persisted
                if($request->image){
                    if( $request->image->isValid() ){
                        Storage::disk('public')->delete('uploads/' .$request->image->hashName());
                    }
                }
                DB::rollBack();
                return back()->with('userNotRegistered');
        }

    }

    public function storeTeacher(Request $request){

        $data = $this->validateStaff($request);
        DB::beginTransaction();

         try {
            //upload the image and store the path
             $data['image'] = $this->uploadUserImage($request);
             $userCreated = UserService::storeTeacher($data);
             //remove basic user info from the $data array
             unset(
                $data['name'] ,
                $data['email'] , 
                $data['password'] , 
                $data['phone_number'] ,
                $data['image']
            );
             //add additional info that StaffInfo model needs which are not present in the $request object
             $data['id'] = $userCreated->id;
             UserService::updateStaffInfo($data);
             DB::commit();
             return back()->with('userRegistered');
 
         }catch (\Exception $e) {
            Log::info( $e->getMessage() );
            //delete the uploaded image (if present ) if the user record was not persisted
            if($request->image){
                if( $request->image->isValid() ){
                    Storage::disk('public')->delete('uploads/' .$request->image->hashName());
                }
            }
            DB::rollBack();
            return back()->with('userNotRegistered');
         }
 
    }

    public function updateStudent(Request $request){
        $data = $this->validateStudent($request);
        DB::beginTransaction();
        try {
            UserService::updateUser($data);
            unset($data['name'] , $data['email'] , $data['phone_number'], $data['section_id']);
            UserService::updateStudentInfo($data);
            DB::commit();
            return back()->with('userUpdated');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return back()->with('userNotUpdated');
        }
    }

    public function updateStaff(Request $request){
        $data = $this->validateStaff($request);
        $data['section_id'] = null;
        DB::beginTransaction();
        try {
            UserService::updateUser($data);
            unset($data['name'] , $data['email'] , $data['phone_number'], $data['section_id']);
            UserService::updateStaffInfo($data);
            DB::commit();
            return back()->with('userUpdated');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return back()->with('userNotUpdated');
        }
    }

    public function index($role , $active , $searchInput = null){
        
        /* if( isset($searchInput) ){

             $students = User::where([ 
                ['role' , 'student' ],
                ['active' , $active],
                ['name' , 'LIKE' , '%' . $searchInput . '%'],
            ])->with('studentInfo')->paginate(1);

           $view = view('users.students.table-list')
            ->with(['students' => $students , 'active' => $active])->render(); 
            return response()->json(['html' => $view]);
        } */

        if($role == 'master' || $role == 'admin'){
            return view('home');
        }

        $users = User::where([
            ['role' , $role],
            ['active' , $active ],
            ])->paginate(3);
        return view('users.index')->with(['users' => $users , 'role' => $role , 'active' => $active]);
    }

    public function edit($id){

        $user = User::where('role' , '!=' , 'master')
        ->where('role', '!=' , 'admin' )->findOrFail($id);

        if($user->role == 'student'){
            $sections = Section::all();
            $schoolSessions = SchoolSession::all();
            return view('users.profile.edit-student')->with([
            'user' => $user ,
            'sections' => $sections , 'schoolSessions' => $schoolSessions]);
        }
        
        return view('users.profile.edit-staff')->with(['user' => $user]);
    }

} 
