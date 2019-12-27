<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Semester;

class SemesterController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all() , [
            'semester_name' => 'required|string|max:30',
            'session_id' => 'required|integer|exists:sessions,id',
            'start_date' => 'required|date|unique:semesters',
            'end_date' => 'required|date|unique:semesters',
            'status' => 'required|in:open,locked',
        ]);

        if( $validator->fails() ){
           return response()->json( [ 'error' => $validator->errors() ]);
        }

        //continue

        //check for unique if semester with session exists
        $num = Semester::where([
            'semester_name' => $request->semester_name,
            'session_id' => $request->session_id,
            ])->count();

        if($num == 0){

            Semester::create([
                'semester_name' => $request->semester_name,
                'session_id' => $request->session_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            return response()->json( [ 'success' => 'semester created'] );

        }

        if($num > 0){
            return response()->json( ['semester_exists' => 'this session already has a ' .strtoupper($request->semester_name) .' semester' ]);
        }


    }
}