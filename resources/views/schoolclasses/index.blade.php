@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">
        @include('include.left-menu')
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"></div>
            <div class="card-body">

                    @if ( $classes->count() )
                        <ul class="nav flex-column">

                            @foreach ($classes as $class)

                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href="{{ url('settings/showclass/' .$class->id )}}"><span
                                class="nav-link-text">{{ $class->id . ' ' .$class->class_name . ' ' .$class->group}}</span></a>
                            </li>
        
                            @endforeach

                        </ul>
                    @else
                        <h3>No class has been made for this school</h3>
                    @endif

            </div>
        </div>
        </div>
    </div>
</div>
@endsection
