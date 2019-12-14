@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @if (Auth::user()->role == 'teacher')
                @foreach ($schoolSessions as $schoolSession)
                    <div>{{$schoolSession->session_name}}</div>
                    <ul>
                        @foreach ($schoolSession->semesters as $semester)
                            <li><a href="{{route('teacher.courses' , ['semester_id' => $semester->id , 'teacher_id' => Auth::user()->id ])}}">{{$semester->semester_name}}</a></li>
                        @endforeach             
                    </ul> 
                @endforeach
            @endif


            @if (Auth::user()->role == 'student')
                <div>{{$currentSession->session_name}}</div>
                @foreach ($currentSession->semesters as $semester)
                    <li><a href="{{route('student.courses' , [ 'section_id' => Auth::user()->section_id , 'semester_id' => $semester->id , 'student_id' => Auth::user()->id ])}}">{{$semester->semester_name}}</a></li>
                @endforeach 
            @endif
            
        </div>
    </div>
</div>
@endsection
