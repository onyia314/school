@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            @if( $schoolClasses->count() )
                <div class="accordion" id="accordionExample">

                    @foreach ($schoolClasses as $schoolClass)
                        
                        <div class="card">
                        <div class="card-header" id="{{'heading' .$schoolClass->id}}">
                            <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="{{ '#collapse' . $schoolClass->id}}" aria-expanded="true" aria-controls="{{'#collapse' . $schoolClass->id}}">
                                {{$schoolClass->class_name .' : ' .$schoolClass->group}}
                            </button>
                            </h2>
                        </div>
                        @if ( $schoolClass->sections->count() )
                            <div id="{{'collapse' . $schoolClass->id}}" class="collapse" aria-labelledby="{{'heading' .$schoolClass->id}}" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">section id</th>
                                            <th scope="col">section name</th>
                                            <th scope="col">view today's attendance</th>
                                            <th scope="col">view each students attendance</th>
                                            <th scope="col">take attendance for today</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($schoolClass->sections as $section)
                                                <tr>
                                                    <th scope="row">{{$section->id}}</th>
                                                    <td>{{$section->section_name}}</td>
                                                    <td><a href="">vew today's attendance</a></td>
                                                    <td><a href="">view each student's attendance</a></td>
                                                    <td><a href="{{route('create.daily.attendance' , ['section_id' => $section->id, ])}}">take attendance</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                        @else
                            <div id="{{'collapse' . $schoolClass->id}}" class="collapse" aria-labelledby="{{'heading' .$schoolClass->id}}" data-parent="#accordionExample">
                                <div class="card-body">
                                    no section for this class
                                </div>
                            </div>
                        @endif
                        

                        </div>

                    @endforeach
                </div>    
            @else 
                <h3>No class created yet</h3>
            @endif
            
        </div>
    </div>
</div>
@endsection
