@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">
        @include('include.left-menu')
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"></div>
            <div class="card-body">

                    @foreach ($schoolClasses as $schoolClass)

                            <div>
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="{{ '#'.$schoolClass->class_name .$schoolClass->id}}" aria-expanded="false" aria-controls="collapseExample">
                                            {{ $schoolClass->class_name .' : ' .$schoolClass->group}}
                                    </button>
                                    
                            </div>
                            
                            <div class="collapse" id="{{ $schoolClass->class_name .$schoolClass->id}}">
                                    <div class="card card-body">

                                    @foreach ($schoolSessions as $schoolSession)

                                    <a href="{{ route('addcourse' , ['session_id' => $schoolSession->id , 'class_id' => $schoolClass->id])}}">
                                        {{ $schoolSession->session_name}}
                                    </a>
                                    @endforeach

                                    </div>
                            </div>
                        
                    @endforeach

                    
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
