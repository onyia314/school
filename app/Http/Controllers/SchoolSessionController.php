<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SchoolSession;

class SchoolSessionController extends Controller
{   
    public function index(){
        $schoolSessions = SchoolSession::all();
        return view('sessions.index')->with('schoolSessions' , $schoolSessions);
    }

    public function show($id){
        $schoolSession = SchoolSession::where('id' , $id)->with('semesters')->get();
        return view('sessions.settings')->with('schoolSession' , $schoolSession);
    }

    public function create(){
        return view('sessions.addsession');
    }

    public function store(Request $request){

        $data = $request->validate([
            'session_name' => 'required|string|max:40|unique:sessions',
        ]);

        try {
            $schoolSession = SchoolSession::create($data);
            return back()->with('sessionAdded' , $schoolSession['id']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return back()->with('sessionNotAdded'); 
        }
       
    }
}
