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
        $classes = SchoolClass::where('id' , $id)->with('sections')->get();

        foreach ($classes as $class) {
            $class_name = $class->class_name;
            $class_id = $class->id;
            $class_group = $class->group;
        }

        return view('schoolclasses.settings')->with([
            'classes' => $classes ,
            'class_name' => $class_name ,
            'class_id' => $class_id,
            'class_group' => $class_group,
        ]);
    }


    public function create(){
        return view('schoolclasses.addclass');
    }

    public function store(Request $request){
        // validate
        $data = $request->validate([
            'class_name' => 'required|string|max:20',
            'group' => 'required|string|max:20',
        ]);

        $num = SchoolClass::where(['class_name' => $data['class_name'] , 'group' => $data['group'], ])->count();

        if($num == 0){
            try {
                $schoolClass = SchoolClass::create($data);
                return back()->with('classAdded' , $schoolClass['id']);
            } catch (\exception $e) {
                Log::info($e->getMessage());
                return back()->with('classNotAdded');
            }
        }

        if($num > 0){
            return back()->with('classExists');
        }
    }
}
