@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('sessionAdded') )
                <div class="alert alert-success text-center">session added value. click <a href="{{url('settings/showsession/' .session('sessionAdded') )}}">here</a> to create semesters for this session</div>
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
                                <label for="start_year" class="col-md-4 col-form-label text-md-right">{{ __('add start year') }}</label>

                                <div class="col-md-6">
                                    <input name="start_year" id="start_year" type="number" min = "2016" max = "2099" step="1" value="2016" class="form-control @error('start_year') is-invalid @enderror"  value="{{ old('start_year') }}">

                                    @error('start_year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="end_year" class="col-md-4 col-form-label text-md-right">{{ __('add end year') }}</label>

                                <div class="col-md-6">
                                    <input name="end_year" id="end_year" type="number" min = "2016" max = "2099" step="1" value="2016" class="form-control @error('end_year') is-invalid @enderror"  value="{{ old('end_year') }}">

                                    @error('end_year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
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
