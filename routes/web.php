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
        Route::get('section/addcourse' , 'CourseController@indexToSemester')->name('section.addcourse');
        Route::get('addcourse/class/{class_id}/section/{section_id}/session/{session_id}/semester/{semester_id}' , 'CourseController@addCourse')->name('addcourse');
        Route::post('addcourse' , 'CourseController@store');

    });

});


//courses for teachers
Route::middleware(['auth' , 'teacher'])->group(function(){
    Route::get('semester/teacher/viewcourse' , 'CourseController@indexTeacher')->name('teacher.viewcourses');
    Route::get('courses/semester/{semester_id}/teacher/{teacher_id}' , 'CourseController@teacherCourses')->name('teacher.courses');
});

//courses for student
Route::middleware(['auth' , 'student'])->group(function(){
    Route::get('semester/student/viewcourse' , 'CourseController@indexStudent')->name('student.viewcourses');
    Route::get('courses/section/{section_id}/semester/{semester_id}/student/{student_id}' , 'CourseController@studentCourses')->name('student.courses');
});

//attendance
Route::middleware(['auth' , 'admin.teacher'])->group(function(){
    //user_id parameter indicates who created an attendace (teacher or admin)
    Route::get('attendance/course/{course_id}/section/{section_id}/semester/{semester_id}/user/{user_id}' , 'AttendanceController@create')->name('create.attendance');
    Route::post('attendance' , 'AttendanceController@store')->name('attendance');
});




//fees

Route::middleware(['auth' , 'admin'])->group(function(){
    Route::prefix('fees')->group(function(){
        Route::get('viewsessions' , 'SchoolSessionController@index');
        Route::get('addfee/{semester_id}' , 'FeeController@create');    
        Route::post('addfee' , 'FeeController@store');
    });
});