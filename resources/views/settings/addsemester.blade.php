@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('semesterAdded') )
                        <div class="alert alert-success text-center">semestser added</div>
                @endif

                @if( session()->exists('semesterNotAdded') )
                        <div class="alert alert-danger text-center">semestser could not be added please contact master</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">Add semester</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('settings/addsemester')}}">
                            @csrf
                            

                            <div class="form-group row">
                                <label for="semester_name" class="col-md-4 col-form-label text-md-right">{{ __('add semester') }}</label>

                                <div class="col-md-6">
                                    <input id="semester_name" type="text" class="form-control @error('semester_name') is-invalid @enderror" name="semester_name" value="{{ old('semester_name') }}"  autocomplete="semester_name" autofocus placeholder="2013/2014 2019/2020">

                                    @error('semester_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

    

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add semester') }}
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
