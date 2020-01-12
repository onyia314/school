@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('feeAdded') )
                 <div class="alert alert-success text-center">fee added</div>
                @endif
                @if( session()->exists('feeExists') )
                    <div class="alert alert-success text-center">fee already made for this section in the selected semester</div>
                @endif

                @if( session()->exists('feeNotAdded') )
                        <div class="alert alert-danger text-center">fee could not be added please contact master</div>
                @endif

                <div class="card">
                <div class="card-header text-center"> add fee for {{$section->schoolClass->class_name .' ' .$section->schoolClass->group  .' ' .$section->section_name}}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store.fee')}}">
                            @csrf
                            

                            <div class="form-group row">
                                <label for="fee_name" class="col-md-4 col-form-label text-md-right">{{ __('fee name') }}</label>

                                <div class="col-md-6">
                                    <input name="fee_name" id="fee_name" type="text" class="form-control @error('fee_name') is-invalid @enderror"  value="{{ old('fee_name') }}"  autocomplete="fee_name" autofocus placeholder="">

                                    @error('fee_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('amount') }}</label>

                                <div class="col-md-6">
                                    <input name="amount" id="amount" type="number" min="0" step="0.01" class="form-control @error('amount') is-invalid @enderror"  value="{{ old('amount') }}" placeholder="eg 100.20" required>

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input name="class_id" type="hidden" class="form-control" value="{{ $section->class_id }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input name="section_id" type="hidden" class="form-control" value="{{ $section->id }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input name="session_id" type="hidden" class="form-control" value="{{ $semester->session_id }}">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                    
                                    <div class="col-md-6">
                                        <input name="semester_id" type="hidden" class="form-control" value="{{$semester->id}}">
                                    </div>
                            </div>
                            

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add fee') }}
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
