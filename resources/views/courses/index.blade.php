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
                        <ul>
                        <li><a href="{{url('settings/addcourse/' .$schoolClass->id)}}">{{ $schoolClass->class_name .' : ' .$schoolClass->group}}</a></li>
                        </ul>
                    @endforeach
                    
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
