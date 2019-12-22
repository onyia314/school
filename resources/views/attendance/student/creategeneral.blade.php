@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @foreach ($sections as $section)
                <h3 class="text-center">{{$section->schoolClass->class_name .' : ' .$section->section_name}}</h3> 
            @endforeach
        
            @if ( session()->exists('attTaken') && session()->exists('studentsDayAttTaken') )
                <div class="alert alert-success text-center">Attendance taken</div>
            @endif

            @if ( !session()->exists('attTaken') && session()->exists('studentsDayAttTaken'))
                <div class="alert alert-danger text-center">today's student general Attendance has been taken</div>
            @endif

            @if ( $sections->count() )
                        
                        <div class = "table-responsive">

                            @if( !( session()->exists('studentsDayAttTaken') )) 

                            <form method="POST" action="{{route('generalStudent.attendance')}}">

                                @csrf
                                <input type="hidden" name="section_id" value="{{$section_id}}">
                                <input type="hidden" name="semester_id" value="{{$semester_id}}">
                                <input type="hidden" name="takenBy_id" value="{{$takenBy_id}}">
                           @endif

                                <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">student id</th>
                                            <th scope="col">student name</th>
                                            @if (!( session()->exists('studentsDayAttTaken') ))
                                            <th scope="col">present</th>
                                            @endif
                                            <th scope="col">total general semester att</th>
                                            <th scope="col">total attended</th>
                                            <th scope="col">total missed</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                            @foreach ($sections as $section)
        
                                                @foreach ($section->users as $student)
                                                    <tr>
                                                        <th scope="row">{{$student->id}}</th>
                                                        <th>{{$student->name}}</th>
                                                        @if (!( session()->exists('studentsDayAttTaken') ))
                                                            <th>
                                                                <input type="checkbox" name = "present[]" value = "{{$student->id}}" class = "present">
                                                                <input type="hidden" name = "users[]" value = "{{$student->id}}">
                                                            </th>
                                                        @endif
    
                                                        <th>{{$attPresent[$student->id] + $attAbsent[$student->id] }}</th>
                                                        <th>{{$attPresent[$student->id]}}</th>
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

                           @if (!( session()->exists('studentsDayAttTaken') ))

                                <button type="submit" class="btn btn-primary" >
                                    {{ __('take attendance') }}
                                </button>      
                            </form>

                           @endif
                            
                        </div>     
                    @else
                        <h3>this course has no students for it yet</h3>
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
