@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @foreach ($sections as $section)
                <h3 class="text-center">{{$section->schoolClass->class_name .' : ' .$section->section_name}}</h3> 
            @endforeach
        
            @if (session()->exists('attTaken'))
                <div class="alert alert-success text-center">Attendance taken</div>
            @endif

            @if (session()->exists('semesterLocked'))
                <div class="alert alert-danger text-center">oops semester is Locked for taking attendance</div>
            @endif

            @if (session()->exists('semesterNotCurrent'))
                <div class="alert alert-danger text-center">you can't take attendance of semester that is not ongoing please contact admin</div>
            @endif

            @if (session()->exists('courseDoesNotBelongToSemester'))
                <div class="alert alert-danger text-center">course does not belong to selescted semester</div>
            @endif

            @if (session()->exists('courseDoesNotBelongToSection'))
                <div class="alert alert-danger text-center">course does not belong to selected section</div>
            @endif

            @if (session()->exists('courseDoesNotBelongToTeacher'))
                <div class="alert alert-danger text-center">you are not authorized to take the attendance of this course</div>
            @endif

            @if ( $sections->count() )
                        
                        <div class = "table-responsive">
                            <form method="POST" action="{{route('courses.attendance')}}">

                                @csrf
                                <input type="hidden" class = "form-control" name="course_id" value="{{$course_id}}">
                                <input type="hidden" class = "form-control" name="section_id" value="{{$section_id}}">
                                <input type="hidden" class = "form-control" name="semester_id" value="{{$semester_id}}">

                                
                                    @error('section_id') 
                                        <div  class="alert alert-danger text-center">
                                        <strong style="color:red">{{ $message }}</strong>
                                        </div> 
                                    @enderror

                                    @error('semester_id') 
                                        <div  class="alert alert-danger text-center">
                                        <strong style="color:red">{{ $message }}</strong>
                                        </div> 
                                    @enderror

                                    @error('course_id') 
                                        <div  class="alert alert-danger text-center">
                                        <strong style="color:red">{{ $message }}</strong>
                                        </div> 
                                    @enderror
                                
                                    @if( $errors->has('students.*') )
                                        @foreach ($errors->get('students.*') as $messages)
                                            @foreach ($messages as $message)
                                                <div class="alert alert-danger text-center">
                                                    <span style="color:red;">{{$message}}</span>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif

                                <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">student id</th>
                                            <th scope="col">student name</th>
                                            <th scope="col">present</th>
                                            <th scope="col">total possible att for student</th>
                                            <th scope="col">total attended</th>
                                            <th scope="col">% present</th>
                                            <th scope="col">total missed</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                            @foreach ($sections as $section)
        
                                                @foreach ($section->users as $student)
                                                    <tr>
                                                        <th scope="row">{{$student->id}}</th>
                                                        <th>{{$student->name}}</th>
                                                        <th>
                                                            <input type="checkbox" name = "present[]" value = "{{$student->id}}" class = "present">
                                                            <input type="hidden" name = "students[]" value = "{{$student->id}}">
                                                        </th>
                                                        <th>{{$attPresent[$student->id] + $attAbsent[$student->id] }}</th>
                                                        <th>{{$attPresent[$student->id]}}</th>
                                                        <th>
                                                            @php
                                                                //to avoid division by zero erro
                                                                if( ($attPresent[$student->id] + $attAbsent[$student->id]) == 0 ){
                                                                    echo '0';
                                                                }else{
                                                                    echo ( ($attPresent[$student->id]) / ($attPresent[$student->id] + $attAbsent[$student->id]) ) * 100;
                                                                }
                                                            @endphp
                                                        </th>
                                                        <th>{{$attAbsent[$student->id]}}</th>
                                                    </tr>
                                                @endforeach
                                                
                                            @endforeach

                                        </tbody> 
                                    </table>

                                    <div>
                                        @error('present')  
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                            {{ __('take attendance') }}
                                    </button>
                            </form>
                            
                        </div>     
                    @else
                        <h3>this section has no students for it yet</h3>
                    @endif
            
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded' , () =>{ 
        var present = document.getElementsByClassName('present');
        for(var i = 0; i < present.length ; i++){
            present[i].checked = true;
        }
    });
</script>
@endsection
