@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            @include('include.left-menu')
            <div class="col-md-8">

                @if( session()->exists('feeUpdated') )
                 <div class="alert alert-success text-center">fee updated</div>
                @endif
                @if( session()->exists('feeNotUpdated') )
                 <div class="alert alert-danger text-center">fee not updated</div>
                @endif
                @if( session()->exists('feeNameExists') )
                 <div class="alert alert-danger text-center">fee name already exists for this section in this semester</div>
                @endif

                <div class="card">
                <div class="card-header text-center"> update fee for</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('update.fee')}}">
                            @csrf
                            
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input name="fee_id" type="hidden" class="form-control" value="{{ $fee->id }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fee_name" class="col-md-4 col-form-label text-md-right">{{ __('fee name') }}</label>

                                <div class="col-md-6">
                                    <input name="fee_name" id="fee_name" type="text" class="form-control @error('fee_name') is-invalid @enderror"  value="{{$fee->fee_name}}" placeholder="">

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
                                    <input name="amount" id="amount" type="number" min="0" step="0.01" class="form-control @error('amount') is-invalid @enderror"  value="{{ $fee->amount }}" placeholder="eg 100.20" required>

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('update fee') }}
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
