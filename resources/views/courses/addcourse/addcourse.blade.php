@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">
        @include('include.left-menu')
        <div class="col-md-6">

                @if( session()->exists('courseAdded') )
                <div class="alert alert-success text-center">course updated</div>
                @endif
                @if( session()->exists('courseNotAdded') )
                <div class="alert alert-danger text-center">course not added please contact developer</div>
                @endif
                @if( session()->exists('courseExists') )
                <div class="alert alert-danger text-center">this course name cannot be created more than once for a section in a semester</div>
                @endif
                @if( session()->exists('invalidRelationShip') )
                <div class="alert alert-danger text-center">oops course not added because of invalid selection</div>
                @endif

                @if ( $suggestedCourses->count() )

                    <div class="card">

                        <div class="card-header text-center"><strong>you can add courses from suggestions</strong></div>
                        
                        <div class="card-body">

                            @foreach ($suggestedCourses as $course)

                                <form method="POST" action="{{ url('settings/addcourse')}}">
                                    @csrf
                                            
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('add course') }}</label>
            
                                        <div class="col-md-6">
                                        <input name="course_name" id="course_name" type="text" class="form-control @error('course_name') is-invalid @enderror"  value="{{$course->course_name}}"  autocomplete="course_name" autofocus placeholder="biology chemistry etc">
            
                                            @error('course_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('course time') }}</label>
            
                                        <div class="col-md-6">
                                        <input name="course_time" id="course_time" type="text" class="form-control @error('course_time') is-invalid @enderror"  value="{{$course->course_time}}"  autocomplete="course_time" autofocus placeholder="eg. 11:00am-12:30pm mondays">
            
                                            @error('course_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('add teacher') }}</label>
            
                                        <div class="col-md-6">
                                            <select name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                                                <option value="">select teacher</option>
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{$teacher->id}}" @if($course->teacher_id == $teacher->id) selected @endif>{{$teacher->name}}</option>                                        
                                                @endforeach
                                            </select>
                                            @error('teacher_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label  class="col-md-4 col-form-label text-md-right">{{ __('select course type') }}</label>
            
                                        <div class="col-md-6">
                                            <select name="course_type" class="form-control @error('course_type') is-invalid @enderror">
                                                    <option value="">select course type</option>                                        
                                                    <option value="core" @if($course->course_type == 'core') selected @endif>core</option>                                        
                                                    <option value="elective" @if($course->course_type == 'elective') selected @endif>elective</option>                                        
                                            </select>
                                            @error('course_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input name="class_id" type="hidden" class="form-control" value="{{ $class_id }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input name="section_id" type="hidden" class="form-control" value="{{ $section_id }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input name="session_id" type="hidden" class="form-control" value="{{ $session_id }}">
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                            
                                            <div class="col-md-6">
                                                <input name="semester_id" type="hidden" class="form-control" value="{{$semester_id}}">
                                            </div>
                                    </div>
            
            
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Add course') }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                </form>

                            @endforeach

                        </div>
                    </div>
                
                @endif {{--if suggested courses count ends--}}

                    <div class="card">
                        <div class="card-header text-center"> <strong>add new course</strong></div>
                        <div class="card-body">
                            <form method="POST" action="{{ url('settings/addcourse')}}">
                                @csrf
                                        
                                <div class="form-group row">
                                    <label for="course_name" class="col-md-4 col-form-label text-md-right">{{ __('add course') }}</label>
        
                                    <div class="col-md-6">
                                    <input name="course_name" id="course_name" type="text" class="form-control @error('course_name') is-invalid @enderror"  value="{{old('course_name')}}"  autocomplete="course_name" autofocus placeholder="biology chemistry etc">
        
                                        @error('course_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="course_time" class="col-md-4 col-form-label text-md-right">{{ __('course time') }}</label>
        
                                    <div class="col-md-6">
                                    <input name="course_time" id="course_time" type="text" class="form-control @error('course_time') is-invalid @enderror"  value="{{old('course_time')}}"  autocomplete="course_time" autofocus placeholder="eg. 11:00am-12:30pm mondays">
        
                                        @error('course_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="teacher_id" class="col-md-4 col-form-label text-md-right">{{ __('add teacher') }}</label>
        
                                    <div class="col-md-6">
                                        <select name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                                            <option value="">select teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{$teacher->id}}" @if( old('teacher_id') == $teacher->id ) selected  @endif>{{$teacher->name}}</option>                                        
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="course_type" class="col-md-4 col-form-label text-md-right">{{ __('select course type') }}</label>
        
                                    <div class="col-md-6">
                                        <select name="course_type" class="form-control @error('course_type') is-invalid @enderror">
                                                <option value="">select course type</option>                                        
                                                <option value="core" @if( old('course_type') == 'core' ) selected  @endif >core</option>                                        
                                                <option value="elective" @if( old('course_type') == 'elective' ) selected  @endif >elective</option>                                        
                                        </select>
                                        @error('course_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input name="class_id" type="hidden" class="form-control" value="{{ $class_id }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input name="section_id" type="hidden" class="form-control" value="{{ $section_id }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input name="session_id" type="hidden" class="form-control" value="{{ $session_id }}">
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                        
                                        <div class="col-md-6">
                                            <input name="semester_id" type="hidden" class="form-control" value="{{$semester_id}}">
                                        </div>
                                </div>
        
        
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Add course') }}
                                        </button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
       
          
        </div> {{--col-md-6 ends--}}

        <div class="col-md-3">

                <div class="card">
                        <div class="card-header text-center">list of courses made for this semester</div>
                        <div class="card-body">
                            @if ($coursesMadeInSelectedSemester->count())
                            <ul>
                                @foreach ($coursesMadeInSelectedSemester as $course)
                                    <li>{{$course->course_name}}</li>
                                @endforeach
                            </ul>
                            @else
                                <h4>no course has been added for this section in this semester</h4>
                            @endif
                        </div>
                </div>
            
        </div>


    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded' , () => {

        var selectAll = document.getElementsByClassName('selectCourse');
        document.getElementById('selectAll').addEventListener('click' , (e) => {
            for ( var i=0; i<selectAll.length; i++) {
                selectAll[i].checked = e.target.checked;
            }
        });

    });

</script>
@endsection
