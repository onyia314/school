@extends('layouts.app')

@section('content')
<div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">

                @if( ( session()->exists('userUpdated') ) && ( session()->exists('infoUpdated') ) )
                        <div class="alert alert-success text-center">{{ $user->role .' ' .'updated'}}</div>
                @endif

                @if( ( session()->exists('userUpdated') ) && !( session()->exists('infoUpdated') ) )
                        <div class="alert alert-danger text-center">{{ $user->role .' ' . 'updated ' .'but biography not updated... please update user biography...if this issue continues contact our support team'}}</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">{{ 'Update' . ' ' .$user->role }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route( 'user.update' , ['id' => $user->id , 'role' => $user->role ] )}}" enctype="multipart/form-data">
                            @csrf

                            {{--
                        
                                updating students does not NECESSARILY require email or phone number 
                                this is separated using the user->role in the input tag

                                authentication is done by registration number or email

                            --}}

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
                                    <input id="birthday" type="date" class="form-control  @error('birthday') is-invalid @enderror" name="birthday" value="{{ $user->birthday }}" required>
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
                                            <option value="christian"  @if( $user->religion == 'christian' ) selected = "selected" @endif>christian</option>
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
                                    <label for="class" class="col-md-4 col-form-label text-md-right">{{ __('class') }}</label>

                                    <div class="col-md-6">

                                    <select name="class" id="class" class = "form-control  @error('class') is-invalid @enderror" required>
                                            <option value="">select class</option>
                                            <option value="jss1" @if( $user->studentInfo->class == 'jss1' ) selected = "selected" @endif>jss1</option>
                                            <option value="jss2" @if( $user->studentInfo->class == 'jss2' ) selected = "selected" @endif>jss2</option>
                                            <option value="jss3" @if( $user->studentInfo->class == 'jss3' ) selected = "selected" @endif>jss3</option>
                                        </select>

                                        @error('class')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="house" class="col-md-4 col-form-label text-md-right">{{ __('house') }}</label>

                                    <div class="col-md-6">

                                    <select name="house" id="house" class = "form-control  @error('house') is-invalid @enderror" required>
                                            <option value="">select house</option>
                                            <option value="jackson"  @if( $user->studentInfo->house == 'jackson' ) selected = "selected" @endif>jackson</option>
                                            <option value="ibiam"  @if( $user->studentInfo->house == 'ibiam' ) selected = "selected" @endif>ibiam</option>
                                            <option value="okpara"  @if( $user->studentInfo->house== 'okpara' ) selected = "selected" @endif>okpara</option>
                                        </select>

                                        @error('house')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('group') }}</label>

                                    <div class="col-md-6">

                                    <select name="group" id="group" class = "form-control  @error('group') is-invalid @enderror" value = {{ $user->group }} required>
                                            <option value="">select group</option>
                                            <option value="science"  @if( $user->studentInfo->group == 'science' ) selected = "selected" @endif>sciene</option>
                                            <option value="art"  @if( $user->studentInfo->group == 'art' ) selected = "selected" @endif>art</option>
                                            <option value="commerce" @if( $user->studentInfo->group == 'commerce' ) selected = "selected" @endif>commerce</option>
                                        </select>

                                        @error('group')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="session" class="col-md-4 col-form-label text-md-right">{{ __('session') }}</label>

                                    <div class="col-md-6">

                                    <select name="session" id="session" class = "form-control  @error('session') is-invalid @enderror" required>
                                            <option value="">select session</option>
                                            <option value="2013/2014"  @if( $user->studentInfo->session == '2013/2014' ) selected = "selected" @endif>2013/2014</option>
                                            <option value="2014/2015"  @if( $user->studentInfo->session == '2014/2015' ) selected = "selected" @endif>2014/2015</option>
                                            <option value="2015/2016"  @if( $user->studentInfo->session == '2015/2016' ) selected = "selected" @endif>2015/2016</option>
                                        </select>

                                        @error('session')
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
