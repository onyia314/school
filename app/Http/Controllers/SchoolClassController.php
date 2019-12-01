<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\SchoolClass;
use App\Section;
class SchoolClassController extends Controller
{

    public function index(){
        $classes = SchoolClass::all();
        return view('schoolclasses.index')->with('classes' , $classes);
    }

    public function show($id){
        $class = SchoolClass::where('id' , $id)->with('sections')->get();
        return view('schoolclasses.settings')->with('class' , $class);
    }


    public function create(){
        return view('settings.addclass');
    }

    public function store(Request $request){
        // validate

        $data = $request->validate([
            'name' => 'required|string|max:20',
            'group' => 'required|string|max:20',
        ]);

        try {
            SchoolClass::create($data);
            return back()->with('classAdded');
        } catch (\exception $e) {
            Log::info($e->getMessage());
            return back()->with('classNotAdded');
        }
    }
}
