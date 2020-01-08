@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @include('include.left-menu')
        
        <div class="col-md-8">
            <div class="card">
            <div class="card-header text-center"><strong>{{ Auth::user()->name .' - ' .Auth::user()->reg_number .' Dashboard'}}</strong></div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>hello {{Auth::user()->role}}</h3>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
