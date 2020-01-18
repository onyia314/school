@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            
            @if( $schoolSessions->count() )

            <div id="accordion">
            
                    @foreach ($schoolSessions as $schoolSession)

                        <div class="card">
                        <div class="card-header" id="{{'heading-' .$schoolSession->id}}">
                                <h5 class="mb-0">
                                <a class="collapsed" role="button" data-toggle="collapse" href="{{'#school' .$schoolSession->id}}" aria-expanded="false" aria-controls="{{'school' .$schoolSession->id}}">
                                        {{$schoolSession->session_name}}
                                    </a>
                                </h5>
                        </div>

                        <div id="{{'school' .$schoolSession->id}}" class="collapse" data-parent="#accordion" aria-labelledby="{{'heading-' .$schoolSession->id}}">
                               
                                <div class="card-body">

                                    @if( $schoolSession->semesters->count() )

                                    <div id="accordion-1">

                                        <div class="card">

                                            @foreach ($schoolSession->semesters as $semester)

                                                <div class="card-header" id="{{'heading-' .$semester->id}}">
                                                    <h5 class="mb-0">
                                                    <a class="collapsed" role="button" data-toggle="collapse" href="{{'#semester'.$semester->id}}" aria-expanded="false" aria-controls="{{'semester' .$semester->id}}">
                                                            {{$semester->semester_name}}
                                                        </a>
                                                    </h5>
                                                </div>

                                                <div id="{{'semester' .$semester->id}}" class="collapse" data-parent="#accordion-1" aria-labelledby="{{'heading-' .$semester->id}}">
                                                    <div class="card-body">

                                                        @if( $sections->count() )

                                                        <div id="accordion-2">
                
                                                            <div class="card">

                                                                @foreach ( $sections as $section )

                                                                    <div class="card-header" id="{{'heading-' .$section->id}}">
                                                                        <h5 class="mb-0">
                                                                        <a class="collapsed" role="button" data-toggle="collapse" href="{{'#section'.$section->id}}" aria-expanded="false" aria-controls="{{'section' .$section->id}}">
                                                                                {{$section->schoolClass->class_name .' ' .$section->schoolClass->class_group . ' ' .$section->section_name}}
                                                                            </a>
                                                                        <a href="{{route('view.fee' , ['section_id' => $section->id , 'semester_id' => $semester->id])}}">view</a>
                                                                        </h5>
                                                                    </div>
        
                                                                @endforeach

                                                            </div>

                                                        </div>

                                                        @else 
                                                            <h5>section does not exist</h5>
                                                        @endif

                                                    </div>
                                                    
    
                                                </div>

                                            @endforeach

                                    </div>
                                    </div>

                                    @else 
                                        <h5>no semester has been made for this session</h5>
                                    @endif
                                </div>
                        </div>

                        </div>

                    @endforeach

            </div>
            @else
                <h5>no session exists</h5>
            @endif 
        </div>
    </div>
</div>
@endsection
