@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('classAdded') )
                        <div class="alert alert-success text-center">class added</div>
                @endif

                @if( session()->exists('classNotAdded') )
                        <div class="alert alert-danger text-center">class could not be added please contact master</div>
                @endif

                @if( session()->exists('classExists') )
                        <div class="alert alert-danger text-center">class with this group already exists</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">Add class</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('settings/addclass')}}">
                            @csrf
                            

                            <div class="form-group row">
                                <label for="class_name" class="col-md-4 col-form-label text-md-right">{{ __('add class') }}</label>

                                <div class="col-md-6">
                                    <input id="class_name" type="text" class="form-control @error('class_name') is-invalid @enderror" name="class_name" value="{{ old('class_name') }}"  autocomplete="class_name" autofocus placeholder="jss1 jss2 etc">

                                    @error('class_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label text-md-right">{{ __("please put 'none' for a class with no group ") }}</label>

                                <div class="col-md-6">
                                    <input id="group" type="text" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ old('group') }}"  autocomplete="group" autofocus placeholder="science,art etc">
                        

                                    @error('group')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add class') }}
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
