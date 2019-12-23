@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('currentSessionDisabled') )
                 <div class="alert alert-success text-center">the session is no longer current</div>
                @endif

                @if( session()->exists('currentSessionDisabledAndClosed') )
                 <div class="alert alert-success text-center">the session is closed and also no longer current</div>
                @endif

                @if( session()->has('currentExists') )
                 <div class="alert alert-danger text-center">
                     session not added because {{ session('currentExists')->session_name }} 
                     is 'current'... please 
                     <a href="{{route('disable.session' , [ 'id' => session('currentExists')->id, ] )}}">
                        disable
                    </a> it before you add a 'current' session. You can also
                     <a href="{{route('disableandclose.session' , [ 'id' => session('currentExists')->id, ] )}}">
                         disable &amp; close it
                    </a> 
                </div>
                @endif

                @if( session()->exists('sessionAdded') )
                    <div class="alert alert-success text-center">session added value. click <a href="">here</a> to create semesters for this session {{session('sessionAdded')}}</div>
                @endif

                @if( session()->exists('sessionNotAdded') )
                        <div class="alert alert-danger text-center">session could not be added please contact master</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">Add session</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('settings/addsession')}}">
                            @csrf
                            

                            <div class="form-group row">
                                <label for="session_name" class="col-md-4 col-form-label text-md-right">{{ __('add session') }}</label>

                                <div class="col-md-6">
                                    <input name="session_name" id="session_name" type="text" class="form-control @error('session_name') is-invalid @enderror"  value="{{ old('session_name') }}"  autocomplete="session_name" autofocus placeholder="2013/2014 2019/2020">

                                    @error('session_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        

                            <div class="form-group row">
                                <span class="col-md-4 col-form-label text-md-right">select status of session : </span>
                                
                                <div class="col-md-6">
    
                                    <label for="open">{{ __('open') }}</label>
                                    <input name="status" id = "open" type="radio" value="open">
                                    
                                    <label for="closed">{{ __('closed') }}</label>
                                    <input name="status" id = "closed" type="radio" value="closed">
                                   
                                    @error('status')
                                    <div>
                                        <span role="alert" style = "color:red;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <span class="col-md-4 col-form-label text-md-right">make session current : </span>
                                <div class="col-md-6">
                                     
                                    <label for="current_true">{{ __('yes') }}</label>
                                    <input name="current" id = "current_true" type="radio" value="1">
                                    
                                    <label for="current_false">{{ __('no') }}</label>
                                    <input name="current" id = "current_false" type="radio" value="0">
                                   
                                    @error('current')
                                    <div>
                                        <span role="alert" style = "color:red;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                    @enderror
                                </div>
                            </div>    

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add session') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
   
</div>
@endsection
