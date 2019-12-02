@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('sessionAdded') )
                        <div class="alert alert-success text-center">session added</div>
                @endif

                @if( session()->exists('sessionNotAdded') )
                        <div class="alert alert-danger text-center">session could not be added please contact master</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">Add class</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('settings/addsession')}}">
                            @csrf
                            

                            <div class="form-group row">
                                <label for="session_name" class="col-md-4 col-form-label text-md-right">{{ __('add session') }}</label>

                                <div class="col-md-6">
                                    <input id="session_name" type="text" class="form-control @error('session_name') is-invalid @enderror" name="session_name" value="{{ old('session_name') }}"  autocomplete="session_name" autofocus placeholder="2013/2014 2019/2020">

                                    @error('session_name')
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
