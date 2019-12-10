<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Section;

class SectionController extends Controller
{
    
    public function store(Request $request){

        
        $validator = Validator::make($request->all() , [
            'section_name' => 'required|string|max:2',
            'class_id' => 'required|integer',
        ]);

        if($validator->fails()){

           return response()->json( [ 'error' => $validator->errors() ]);

        }

        //continue

        //check for unique class room
        $num = Section::where([
            'section_name' => $request->section_name,
            'class_id' => $request->class_id,
            ])->count();

        if($num == 0){

            Section::create([
                'section_name' => $request->section_name,
                'class_id' => $request->class_id,
            ]);

            return response()->json( [ 'success' => 'section created'] );

        }

        if($num > 0){
            return response()->json( ['class_exists' => 'this class already has this section ' .strtoupper($request->section_name) ]);
        }


    }
}
