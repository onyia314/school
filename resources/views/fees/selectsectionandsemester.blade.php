@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            
            @if( $schoolClasses->count() )

            <div id="accordion">
            
                    @foreach ($schoolClasses as $schoolClass)

                        <div class="card">
                        <div class="card-header" id="{{'heading-' .$schoolClass->id}}">
                                <h5 class="mb-0">
                                <a class="collapsed" role="button" data-toggle="collapse" href="{{'#school'.$schoolClass->class_name .$schoolClass->id}}" aria-expanded="false" aria-controls="{{'school' .$schoolClass->class_name .$schoolClass->id}}">
                                        {{$schoolClass->class_name .' : ' .$schoolClass->group}}
                                    </a>
                                </h5>
                        </div>

                        <div id="{{'school' .$schoolClass->class_name .$schoolClass->id}}" class="collapse" data-parent="#accordion" aria-labelledby="{{'heading-' .$schoolClass->id}}">
                               
                                <div class="card-body">

                                    @if( $schoolClass->sections->count() )

                                    <div id="accordion-1">

                                        <div class="card">

                                            @foreach ($schoolClass->sections as $section)

                                                <div class="card-header" id="{{'heading-' .$section->id}}">
                                                    <h5 class="mb-0">
                                                    <a class="collapsed" role="button" data-toggle="collapse" href="{{'#section'.$section->id}}" aria-expanded="false" aria-controls="{{'section' .$section->id}}">
                                                            {{$section->section_name}}
                                                        </a>
                                                    </h5>
                                                </div>

                                                <div id="{{'section' .$section->id}}" class="collapse" data-parent="#accordion-1" aria-labelledby="{{'heading-' .$section->id}}">
                                                    <div class="card-body">

                                                        @if( $schoolSessions->count() )

                                                        <div id="accordion-2">
                
                                                            <div class="card">

                                                                @foreach ( $schoolSessions as $schoolSession )

                                                                    <div class="card-header" id="{{'heading-' .$schoolSession->id}}">
                                                                        <h5 class="mb-0">
                                                                        <a class="collapsed" role="button" data-toggle="collapse" href="{{'#session'.$schoolSession->id}}" aria-expanded="false" aria-controls="{{'session' .$schoolSession->id}}">
                                                                                {{$schoolSession->session_name}}
                                                                            </a>
                                                                        </h5>
                                                                    </div>
        
                                                                    <div id="{{'session' .$schoolSession->id}}" class="collapse" data-parent="#accordion-2" aria-labelledby="{{'heading-' .$schoolSession->id}}">
                                                                        
                                                                        <div class="card-body">

                                                                            @if( $schoolSession->semesters->count() )

                                                                            <div id="accordion-3">

                                                                                <div class="card">
                                                                                    @foreach ($schoolSession->semesters as $semester)
                                                                                <strong>{{$semester->semester_name}}</strong>
                                                                                        <a href="{{route('create.fee' , [ 'section_id' => $section->id , 'semester_id' => $semester->id ])}}">add fee</a>
                                                                                        <a href="{{route('view.fee' , [ 'section_id' => $section->id , 'semester_id' => $semester->id ])}}">view fee</a>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            @else 
                                                                                <h5>no semesters has been made</h5>
                                                                            @endif

                                                                        </div>
                        
                                                                    </div>
        
                                                                @endforeach

                                                            </div>

                                                        </div>

                                                        @else 
                                                            <h5>no session has been made</h5>
                                                        @endif

                                                    </div>
                                                    
    
                                                </div>

                                            @endforeach

                                    </div>
                                    </div>

                                    @else 
                                        <h5>no section for this class</h5>
                                    @endif
                                </div>
                        </div>

                        </div>

                    @endforeach

            </div>
            @else
                <h5>no class has been made for this school</h5>
            @endif 
        </div>
    </div>
</div>
@endsection
