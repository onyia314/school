@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @foreach ($sections as $section)
                <h3 class="text-center">{{$section->schoolClass->class_name .' : ' .$section->section_name}}</h3> 
            @endforeach
        
            @if ( session()->exists('attTaken') && session()->exists('studentsDailyAttTaken') )
                <div class="alert alert-success text-center">Attendance taken</div>
            @endif

            @if ( !session()->exists('attTaken') && ( session()->exists('studentsDailyAttTaken') && session('studentsDailyAttTaken') == $section_id ) )
                <div class="alert alert-danger text-center">today's student general Attendance has been taken for this section</div>
            @endif

            @if (session()->exists('semesterNotCurrent'))
                <div class="alert alert-danger text-center">oops we are not in the selected semester</div>
            @endif

            @if (session()->exists('semesterLocked'))
                <div class="alert alert-danger text-center">oops semester is Locked for taking attendance</div>
            @endif

            @if ( $sections->count() )
                        
                        <div class = "table-responsive">

                            {{-- show form only when today's attendance for this section has not been taken --}}
                            @if( !session()->exists('studentsDailyAttTaken') || session('studentsDailyAttTaken') != $section_id  ) 

                            <form method="POST" action="{{route('daily.attendance')}}">
                                @csrf
                                <input type="hidden" class = "form-control" name="section_id" value="{{$section_id}}">
                                <input type="hidden" class = "form-control" name="semester_id" value="{{$semester_id}}">
                                <div>
                                    @error('section_id')  
                                            <strong style="color:red">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div>
                                    @error('semester_id')  
                                            <strong style="color:red;">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div>
                                    @if( $errors->has('students.*') )
                                        @foreach ($errors->get('students.*') as $messages)
                                            @foreach ($messages as $message)
                                                <div><span style="color:red;">{{$message}}</span></div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                           
                            @endif

                                <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">student id</th>
                                            <th scope="col">student name</th>
                                            @if (!session()->exists('studentsDailyAttTaken') )
                                            <th scope="col">present</th>
                                            @endif
                                            <th scope="col">total possible att for student this semester</th>
                                            <th scope="col">total attended</th>
                                            <th scope="col">total missed</th>
                                            <th scope="col">% attended</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                            @foreach ($sections as $section)
        
                                                @foreach ($section->users as $student)
                                                    <tr>
                                                        <th scope="row">{{$student->id}}</th>
                                                        <th>{{$student->name}}</th>
                                                        @if ( !session()->exists('studentsDailyAttTaken') || session('studentsDailyAttTaken') != $section_id)
                                                            <th>
                                                                <input type="checkbox" name = "present[]" value = "{{$student->id}}" class = "present">
                                                                <input type="hidden" name = "students[]" value = "{{$student->id}}">
                                                            </th>
                                                        @endif
    
                                                        <th>{{$attPresent[$student->id] + $attAbsent[$student->id] }}</th>
                                                        <th>{{$attPresent[$student->id]}}</th>
                                                        <th>{{$attAbsent[$student->id]}}</th>
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

                           @if ( !session()->exists('studentsDailyAttTaken') || session('studentsDailyAttTaken') != $section_id)

                                <button type="submit" class="btn btn-primary" >
                                    {{ __('take attendance') }}
                                </button>      
                            </form>

                           @endif
                            
                        </div> 
                    @else
                    <h3>this sections has no student yet</h3>    
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
