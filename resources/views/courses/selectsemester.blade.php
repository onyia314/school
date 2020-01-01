@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @if (Auth::user()->role == 'teacher')

                @if( $schoolSessions->count() )
                    @foreach ($schoolSessions as $schoolSession)
                        <div>{{$schoolSession->session_name}}</div>

                        @if($schoolSession->semesters->count())
                            <ul>
                                @foreach ($schoolSession->semesters as $semester)
                                    <li><a href="{{route( 'teacher.courses' , ['semester_id' => $semester->id] )}}">{{$semester->semester_name}}</a></li>
                                @endforeach             
                            </ul> 
                        @else
                            <h5>no semester made for this session</h5>
                        @endif
                        
                    @endforeach
                @else
                    <h3>no session has been made</h3>
                @endif

            @endif

        </div>
    </div>
</div>
@endsection
