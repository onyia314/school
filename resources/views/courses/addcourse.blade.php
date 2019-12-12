@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">
        @include('include.left-menu')
        <div class="col-md-6">

                @if( session()->exists('courseAdded') )
                <div class="alert alert-success text-center">course updated</div>
                @endif

            <div class="card">
            <div class="card-header text-center">add courses</div>
            <div class="card-body">

                    <form method="POST" action="{{ url('settings/addcourse')}}">
                        @csrf
                        
                        
                        <div class="form-group-row">

                            @if ($suggestedCourses->count())

                                <strong>here are the list of course suggestions</strong>
                                
                                <ul>
                                    <li>select all : <input type="checkbox" id = "selectAll"></li>
                                    @foreach ($suggestedCourses as $suggestedCourse)
                                        <li>{{$suggestedCourse .' : '}}<input name = "course_name[]" class = "selectCourse"type="checkbox" @error('course_name') is-invalid @enderror value = "{{$suggestedCourse}}"></li>
                                    @endforeach
                                </ul>
                                
                            @endif
                            
                        </div>
                        

                        <div class="form-group row">
                            <label for="course_name" class="col-md-4 col-form-label text-md-right">{{ __('add course') }}</label>

                            <div class="col-md-6">
                                <input name="course_name[]" id="course_name" type="text" class="form-control @error('course_name') is-invalid @enderror"  value=""  autocomplete="course_name" autofocus placeholder="biology chemistry etc">

                                @error('course_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="class_id" name="class_id" type="hidden" class="form-control" value="{{ $class_id }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="section_id" name="section_id" type="hidden" class="form-control" value="{{ $section_id }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="session_id" name="session_id" type="hidden" class="form-control" value="{{ $session_id }}">
                            </div>
                        </div>

                        <div class="form-group row">
                                
                                <div class="col-md-6">
                                    <input id="semester_id" name="semester_id" type="hidden" class="form-control" value="{{$semester_id}}">
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
        </div>

        <div class="col-md-3">

                <div class="card">
                        <div class="card-header text-center">list of courses made for this semester</div>
                        <div class="card-body">
                            @if ($coursesMadeInSelectedSemester->count())
                            <ul>
                                @foreach ($coursesMadeInSelectedSemester as $course)
                                    <li>{{$course}}</li>
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
