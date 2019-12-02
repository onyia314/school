<?php

namespace App\Http\Controllers;

use App\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FeeController extends Controller
{
    public function create($semester_id){
        return view('fees.settings')->with('semester_id' , $semester_id);
    } 

    public function store(Request $request){

        
        $validator = Validator::make($request->all() , [
            'fee_name' => 'required|string|max:225',
            'semester_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);

        if($validator->fails()){

           return response()->json( [ 'error' => $validator->errors() ]);

        }

        //continue

        //check for unique fee for a semester
        $num = Fee::where([
            'name' => $request->name,
            'semester_id' => $request->semester_id,
            ])->count();

        if($num == 0){

            Fee::create([
                'name' => $request->name,
                'semester_id' => $request->semester_id,
                'amount' => $request->amount,
            ]);

            return response()->json( [ 'success' => 'fee created'] );

        }

        if($num > 0){
            return response()->json( ['fee_exists' => 'this semester already has a fee' .' ' .strtoupper($request->name) ]);
        }


    }
}
