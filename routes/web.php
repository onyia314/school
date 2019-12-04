<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// the default laravel route for register has been modified 


Route::get('/home', 'HomeController@index')->name('home');


//accessible to only admin and master
Route::middleware(['auth' , 'admin.master'])->group(function(){

    Route::get('/register' , function(){

        if( session()->has('register_role') && session('register_role') == 'student' ){
            $sections = \App\Section::has('schoolClass')->with('schoolClass')->get();
            $schoolSessions = \App\SchoolSession::all();
            return view('auth.register')->with(['sections' => $sections , 'schoolSessions' => $schoolSessions]);
        }

        return view('auth.register');

    })->name('register');

    /**
     * group all the different route to register users based on their roles
     */
    Route::prefix('register')->group(function(){

        Route::get('student' , function(){

            session([
                'register_role' => 'student',
                ]);

            return redirect()->route('register');
            
        });

        Route::get('teacher' , function(){
            session(['register_role' => 'teacher']);
            return redirect()->route('register');
        });

        Route::post('student' , 'UserController@storeStudent');
        Route::post('teacher' , 'UserController@storeTeacher');

    });
});


Route::middleware(['auth' , 'admin.master'])->group(function(){
    Route::get('user/edit/{id}' , 'UserController@edit')->name('user.edit');
    Route::post('user/edit/{id}/{role}' , 'UserController@update')->name('user.update');
});


Route::middleware(['auth' , 'admin'])->group(function(){
    Route::get('settings' , function(){
        return view('settings.index');
    })->name('settings');
});


Route::middleware(['auth' , 'admin'])->group(function(){

    Route::prefix('settings')->group(function(){

        Route::get('addclass', 'SchoolClassController@create');
        Route::post('addclass' , 'SchoolClassController@store');
        Route::get('viewclasses' , 'SchoolClassController@index');
        Route::get('showclass/{id}' , 'SchoolClassController@show'); // takes you to where you can add section of a class room

        Route::post('addsection' , 'SectionController@store');

        Route::get('addsession' , 'SchoolSessionController@create');
        Route::post('addsession' , 'SchoolSessionController@store');
        Route::get('viewsessions' , 'SchoolSessionController@index');
        Route::get('showsession/{id}' , 'SchoolSessionController@show'); //takes you to where you can add semester

        Route::post('addsemester' , 'SemesterController@store');

        /**
         * add courses
         */
        Route::get('viewclasses/addcourse' , 'CourseController@index')->name('viewclasses.addcourse');
        Route::get('addcourse/{class_id}' , 'CourseController@addCourse');
        Route::post('addcourse' , 'CourseController@store');


    });

});

//fees

Route::middleware(['auth' , 'admin'])->group(function(){
    Route::prefix('fees')->group(function(){
        Route::get('viewsessions' , 'SchoolSessionController@index');
        Route::get('addfee/{semester_id}' , 'FeeController@create');
        
        Route::post('addfee' , 'FeeController@store');
    });
});