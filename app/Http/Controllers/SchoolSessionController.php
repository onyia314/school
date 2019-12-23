<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SchoolSession;
use App\Services\SchoolSession\SchoolSessionService;

class SchoolSessionController extends Controller
{   
    public function index(){
        $schoolSessions = SchoolSession::all();
        return view('sessions.index')->with('schoolSessions' , $schoolSessions);
    }

    public function create(){
        return view('sessions.addsession');
    }

    public function show($id){
        $schoolSession = SchoolSession::where('id' , $id)->with('semesters')->first();
        return view('sessions.settings')->with('schoolSession' , $schoolSession);
    }

    public function edit($id){
        $schoolSession = SchoolSession::where('id' , $id)->first();
        return view('sessions.edit')->with('schoolSession' , '$schoolSession');
    }

    public function update(){
        //do stuf here
    }

    public function store(Request $request){

        $data = $request->validate([
            'session_name' => 'required|string|max:40|unique:sessions',
            'status' => 'required|string|max:40',
            'current' => 'required|integer',
        ]);
        
        $currentSession = SchoolSessionService::currentSession();

        if( $currentSession && $data['current'] == 1 ){
            return back()->with('currentExists' , $currentSession);
        }

        try {
            $schoolSession = SchoolSession::create($data);
            return back()->with('sessionAdded' , $schoolSession['id']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return back()->with('sessionNotAdded'); 
        }
       
    }
}
