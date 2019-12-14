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
                                <a class="collapsed" role="button" data-toggle="collapse" href="{{'#school'.$schoolClass->class_name .$schoolClass->id}}" aria-expanded="false" aria-controls="{{'school' .$schoolClass->class_name .$schoolClass->id}}">
                                        {{$schoolClass->class_name .' : ' .$schoolClass->group}}
                                    </a>
                                </h5>
                        </div>

                        <div id="{{'school' .$schoolClass->class_name .$schoolClass->id}}" class="collapse" data-parent="#accordion" aria-labelledby="{{'heading-' .$schoolClass->id}}">
                               
                                <div class="card-body">

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
                                                                            <div id="accordion-3">
                                                                                <div class="card">
                                                                                    @foreach ($schoolSession->semesters as $semester)
                                                                                        <a href="{{route('addcourse' , [ 'class_id' => $schoolClass->id , 'section_id' => $section->id ,'session_id' => $schoolSession->id , 'semester_id' => $semester->id])}}">{{$semester->semester_name}}</a>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                        
                                                                    </div>
        
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                    
    
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
