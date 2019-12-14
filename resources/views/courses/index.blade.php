@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @if (Auth::user()->role == 'teacher')
            
                    @if ( $courses->count() )
                        
                        <div class = "table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">course id</th>
                                    <th scope="col">course name</th>
                                    <th scope="col">course type</th>
                                    <th scope="col">class name</th>
                                    <th scope="col">class group</th>
                                    <th scope="col">section</th>
                                    <th scope="col">time</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($courses as $course)
                                        <tr>
                                            <th scope="row">{{$course->id}}</th>
                                            <td>{{$course->course_name}}</td>
                                            <td>{{$course->course_type}}</td>
                                            <td>{{$course->schoolClass->class_name}}</td>
                                            <td>{{$course->schoolClass->group}}</td>
                                            <td>{{$course->section->section_name}}</td>
                                            <td>{{$course->course_time}}</td>
                                        </tr>   
                                        
                                    @endforeach
                                </tbody> 
                            </table> 
                        </div>     
                    @else
                        <h3>you have not been assigned to any course for this semester</h3>
                    @endif
                    
            @endif


           @if (Auth::user()->role == 'student')

                @if ($courses->count() )

                    <div class = "table-responsive">

                    <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">course id</th>
                                <th scope="col">course name</th>
                                <th scope="col">course type</th>
                                <th scope="col">class name</th>
                                <th scope="col">class group</th>
                                <th scope="col">section</th>
                                <th scope="col">time</th>
                                <th scope="col">teacher</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                                @foreach ($courses as $course)
                                    <tr>
                                        <th scope="row">{{$course->id}}</th>
                                        <td>{{$course->course_name}}</td>
                                        <td>{{$course->course_type}}</td>
                                        <td>{{$course->schoolClass->class_name}}</td>
                                        <td>{{$course->schoolClass->group}}</td>
                                        <td>{{$course->section->section_name}}</td>
                                        <td>{{$course->course_time}}</td>
                                        <td>{{$course->teacher->name}}</td>
                                    </tr>   
                                    
                                @endforeach
                            </tbody> 
                        </table>
                    </div>
                @else
                    <h3>the school has not added course for this section in this semester</h3> 
                @endif
            
            @endif
            
        </div>
    </div>
</div>
@endsection
