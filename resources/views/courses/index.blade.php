@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            
            <div id="accordion">

                    @foreach ($schoolClasses as $schoolClass)

                        <div class="card">
                        <div class="card-header" id="{{'heading-' .$schoolClass->id}}">
                                <h5 class="mb-0">
                                <a class="collapsed" role="button" data-toggle="collapse" href="{{'#school'.$schoolClass->class_name .$schoolClass->id}}" aria-expanded="false" aria-controls="{{'school' .$schoolClass->class_name}}">
                                        {{$schoolClass->class_name .' : ' .$schoolClass->group}}
                                    </a>
                                </h5>
                        </div>

                        <div id="{{'school' .$schoolClass->class_name .$schoolClass->id}}" class="collapse" data-parent="#accordion" aria-labelledby="{{'heading-' .$schoolClass->id}}">
                               
                                <div class="card-body">

                                    <div id="accordion-1">

                                        <div class="card">

                                            @foreach ($schoolSessions as $schoolSession)

                                                <div class="card-header" id="{{'heading-' .$schoolSession->id .$schoolClass->id}}">
                                                    <h5 class="mb-0">
                                                    <a class="collapsed" role="button" data-toggle="collapse" href="{{'#session'.$schoolSession->id .$schoolClass->id}}" aria-expanded="false" aria-controls="{{'session' .$schoolSession->id .$schoolClass->id}}">
                                                            {{$schoolSession->session_name}}
                                                        </a>
                                                    </h5>
                                                </div>

                                                <div id="{{'session' .$schoolSession->id .$schoolClass->id}}" class="collapse" data-parent="#accordion-1" aria-labelledby="{{'heading-' .$schoolSession->id .$schoolClass->id}}">
                                                    <ul>
                                                        @foreach ( $schoolSession->semesters as $semester )
                                                            <li>
                                                                <a href="{{route('addcourse' , ['session_id' => $schoolSession->id , 'class_id' => $schoolClass->id, 'semester_id' => $semester->id ])}}">
                                                                        {{$semester->semester_name}}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
    
                                                </div>

                                            @endforeach

                                    </div>
                                    </div>
                                </div>
                        </div>

                        </div>

                    @endforeach

            </div>
                
        </div>
    </div>
</div>
@endsection
