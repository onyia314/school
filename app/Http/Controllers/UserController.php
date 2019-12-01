<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function validateStudent($request){

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:50|unique:users',
            'birthday' => 'required|date',
            'nationality' => 'required|string|max:100',
            'state_of_origin' => 'required|string|max:100',
            'gender' => 'required|string',
            'religion' => 'required|string',
            'address' => 'required|string|max:225',
            'section_id' => 'required|integer',
            'session_id' => 'required|integer',
            'father_name' => 'required|string|max:255',
            'father_phone' => '|nullable|required_without:mother_phone|string|max:50',
            'mother_name' => 'required|string|max:255',
            'mother_phone' => 'nullable|required_without:father_phone|string|max:50',
            'image' => 'file|image|max:5036',
        ]);

        return $data;

    }

    public function storeStudent(Request $request){

       $data = $this->validateStudent($request);

        //check existence of file,upload and get the path
        if( $request->hasFile('image') )
        {
            $path = $request->image->store('uploads' , 'public');
            $data['image'] = $path;
        }
        else
        {
            $path = '';
            $data['image'] = $path;
        }

        try {

            $userCreated = UserService::storeStudent($data);

            //remove basic user info from the $data array
            unset($data['name'] , $data['email'] , $data['password'] , $data['phone_number'] , $data['image'] , $data['section_id']);

            //add additional info that StudentInfo model needs which are not present in the $request object
            $data['user_id'] = $userCreated->id;

            try {
               UserService::updateStudentInfo($data);
               session()->flash('infoRegistered');
            } catch (\Exception $e) {
                Log::info( $e->getMessage() );
            }
        } catch (\Exception $e) {
            Log::info( $e->getMessage() );

            //delete the uploaded image if the user record was not persisted
            Storage::disk('public')->delete('uploads/' .$request->image->hashName());
            return back()->with('userNotRegistered');
        }

        return back()->with('userRegistered');
    }
}
