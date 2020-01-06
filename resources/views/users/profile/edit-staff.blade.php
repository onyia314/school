@extends('layouts.app')

@section('content')
<div class="container">

        <div class="row justify-content-center">

            @include('include.left-menu')

            <div class="col-md-8">

                @if( ( session()->exists('userUpdated') ) )
                        <div class="alert alert-success text-center">{{ $user->role .' ' .'updated'}}</div>
                @endif

                @if( ( session()->exists('userNotUpdated') ) )
                        <div class="alert alert-danger text-center">{{ $user->role .' ' .'could not be updated due to system error'}}</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">{{ 'Update' . ' ' .$user->role }}</div>

                    <div class="card-body">
                        <form method="post" action="{{ route( 'staff.update')}}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ $user->id }}" required>

                                    @error('id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name}}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $user->phone_number }}" required>


                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                                
                            <div class="form-group row">
                                <label for="birthday" class="col-md-4 col-form-label text-md-right ">{{ __('birthday') }}</label>

                                <div class="col-md-6">
                                <input name="birthday" id="birthday" type="date" class="form-control  @error('birthday') is-invalid @enderror"  required value="{{$user->staffInfo->birthday}}">
                                    @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="nationality" class="col-md-4 col-form-label text-md-right">{{ __('nationality') }}</label>

                                <div class="col-md-6">
                                    <input id="nationality" type="text" class="form-control  @error('nationality') is-invalid @enderror" name="nationality" value="{{ $user->staffInfo->nationality }}" required>
                                    @error('nationality')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="state_of_origin" class="col-md-4 col-form-label text-md-right">{{ __('state of origin') }}</label>

                                <div class="col-md-6">
                                    <input id="state_of_origin" type="text" class="form-control  @error('state_of_origin') is-invalid @enderror" name="state_of_origin" value="{{ $user->staffInfo->state_of_origin }}" required>
                                    @error('state_of_origin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('gender') }}</label>

                                    <div class="col-md-6">

                                        <select name="gender" id="gender" class = "form-control  @error('gender') is-invalid @enderror" required>
                                                <option value="">select gender</option>
                                                <option value="male" @if( $user->staffInfo->gender == 'male' ) selected = "selected" @endif>male</option>
                                                <option value="female" @if( $user->staffInfo->gender == 'female' ) selected = "selected" @endif>female</option>
                                        </select>

                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                            </div>

                            <div class="form-group row">
                                    <label for="religion" class="col-md-4 col-form-label text-md-right">{{ __('religion') }}</label>

                                    <div class="col-md-6">

                                        <select name="religion" id="religion" class = "form-control  @error('religion') is-invalid @enderror" required >
                                            <option value="">select religion</option>
                                            <option value="christian"  @if( $user->staffInfo->religion == 'christian' ) selected = "selected" @endif>christian</option>
                                            <option value="islam" @if( $user->staffInfo->religion == 'islam' ) selected = "selected" @endif>islam</option>
                                            <option value="others" @if( $user->staffInfo->religion == 'others' ) selected = "selected" @endif>others</option>
                                        </select>

                                        @error('religion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                            </div>


                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{ $user->staffInfo->address }}" required autocomplete="address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                            </div>
                            
                            <div class="form-group row">

                                <label for="qualification" class="col-md-4 col-form-label text-md-right">{{ __('qualification') }}</label>

                                <div class="col-md-6">
                                    <input id="qualification" type="text" class="form-control  @error('qualification') is-invalid @enderror" name="qualification" value="{{$user->staffInfo->qualification}}" required>
                                    @error('qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="next_of_kin" class="col-md-4 col-form-label text-md-right">{{ __('next of kin') }}</label>

                                <div class="col-md-6">
                                    <input id="next_of_kin" type="text" class="form-control  @error('next_of_kin') is-invalid @enderror" name="next_of_kin" value="{{$user->staffInfo->next_of_kin}}" required>
                                    @error('next_of_kin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="next_of_kin_phone" class="col-md-4 col-form-label text-md-right">{{ __('next of kin phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="next_of_kin_phone" type="text" class="form-control  @error('next_of_kin_phone') is-invalid @enderror" name="next_of_kin_phone" value="{{$user->staffInfo->next_of_kin_phone }}" required>
                                    @error('next_of_kin_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="referee" class="col-md-4 col-form-label text-md-right">{{ __('referee') }}</label>

                                <div class="col-md-6">
                                    <input id="referee" type="text" class="form-control  @error('referee') is-invalid @enderror" name="referee" value="{{$user->staffInfo->referee }}" required>
                                    @error('referee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            
                            <div class="form-group row">

                                <label for="referee_phone" class="col-md-4 col-form-label text-md-right">{{ __('referee phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="referee_phone" type="text" class="form-control  @error('referee_phone') is-invalid @enderror" name="referee_phone" value="{{$user->staffInfo->referee_phone }}" required>
                                    @error('referee_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="previous" class="col-md-4 col-form-label text-md-right">{{ __('previous') }}</label>

                                <div class="col-md-6">
                                    <input id="previous" type="text" class="form-control  @error('previous') is-invalid @enderror" name="previous" value="{{$user->staffInfo->previous}}" required>
                                    @error('previous')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
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
