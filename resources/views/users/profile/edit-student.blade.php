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
                        <form method="post" action="{{ route( 'student.update')}}">
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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" <?php if( $user->role !== 'student'){echo 'required';}?> autocomplete="email">

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
                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $user->phone_number }}" <?php if( $user->role !== 'student'){echo 'required';}?>>


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
                                <input name="birthday" id="birthday" type="date" class="form-control  @error('birthday') is-invalid @enderror"  required value="{{$user->studentInfo->birthday}}">
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
                                    <input id="nationality" type="text" class="form-control  @error('nationality') is-invalid @enderror" name="nationality" value="{{ $user->studentInfo->nationality }}" required>
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
                                    <input id="state_of_origin" type="text" class="form-control  @error('state_of_origin') is-invalid @enderror" name="state_of_origin" value="{{ $user->studentInfo->state_of_origin }}" required>
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
                                                <option value="male" @if( $user->studentInfo->gender == 'male' ) selected = "selected" @endif>male</option>
                                                <option value="female" @if( $user->studentInfo->gender == 'female' ) selected = "selected" @endif>female</option>
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
                                            <option value="christian"  @if( $user->studentInfo->religion == 'christian' ) selected = "selected" @endif>christian</option>
                                            <option value="islam" @if( $user->studentInfo->religion == 'islam' ) selected = "selected" @endif>islam</option>
                                            <option value="others" @if( $user->studentInfo->religion == 'others' ) selected = "selected" @endif>others</option>
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
                                    <input id="address" type="text" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{ $user->studentInfo->address }}" required autocomplete="address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                            </div>
                            
                            {{--
                                extra field of student
                            --}}

                            @if( $user->role == 'student')

                                <div class="form-group row">
                                    <label for="section_id" class="col-md-4 col-form-label text-md-right">{{ __('class-group-section') }}</label>

                                    <div class="col-md-6">

                                        <select name="section_id" id="section_id" class = "form-control  @error('section_id') is-invalid @enderror" required>
                                                <option value="">select class</option>
                                            
                                            @foreach ( $sections as $section)

                                                <option value="{{$section->id}}" @if( $user->section->id == $section->id) selected = "selected" @endif>
                                                    {{$section->schoolClass->class_name .' : ' .$section->schoolClass->group . ' : ' .$section->section_name}}
                                                </option>
                                                
                                            @endforeach

                                        </select>

                                        @error('section_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="session_id" class="col-md-4 col-form-label text-md-right">{{ __('session') }}</label>

                                    <div class="col-md-6">

                                        <select name="session_id" id="session_id" class = "form-control  @error('session_id') is-invalid @enderror" required>
                                            <option value="">select session</option>
                                            @foreach ($schoolSessions as $schoolSession)
                                                <option value="{{$schoolSession->id}}" @if( $user->studentInfo->session_id == $schoolSession->id) selected = "selected" @endif>
                                                    {{$schoolSession->session_name}}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('session_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="father_name" class="col-md-4 col-form-label text-md-right">{{ __('father\'s name') }}</label>

                                    <div class="col-md-6">
                                        <input id="father_name" type="text" class="form-control  @error('father_name') is-invalid @enderror" name="father_name" value="{{ $user->studentInfo->father_name }}" required autocomplete="father_name">
                                        @error('father_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label for="father_phone" class="col-md-4 col-form-label text-md-right">{{ __('father\'s phone number ##') }}</label>

                                    <div class="col-md-6">
                                        <input id="father_phone" type="text" class="form-control  @error('father_phone') is-invalid @enderror" name="father_phone" value="{{ $user->studentInfo->father_phone }}">
                                        @error('father_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="mother_name" class="col-md-4 col-form-label text-md-right">{{ __('mother\'s name') }}</label>

                                    <div class="col-md-6">
                                        <input id="mother_name" type="text" class="form-control  @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ $user->studentInfo->mother_name }}" required autocomplete="mother_name">
                                        @error('mother_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="mother_phone" class="col-md-4 col-form-label text-md-right">{{ __('mother\'s phone number ##') }}</label>

                                    <div class="col-md-6">
                                        <input id="mother_phone" type="text" class="form-control  @error('mother_phone') is-invalid @enderror" name="mother_phone" value="{{ $user->studentInfo->mother_phone }}">
                                        @error('mother_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>


                            @endif


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
