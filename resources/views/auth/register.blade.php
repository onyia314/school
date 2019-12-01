@extends('layouts.app')

@section('content')

<div class="container">

    @if(session()->has('register_role'))
        <div class="row justify-content-center">

            @include('include.left-menu')
            
            <div class="col-md-8">

                @if( ( session()->exists('userRegistered') ) && ( session()->exists('infoRegistered') ) )
                        <div class="alert alert-success text-center">{{ session('register_role') . ' ' .'registered'}}</div>
                @endif

                @if( ( session()->exists('userRegistered') ) && !( session()->exists('infoRegistered') ) )
                        <div class="alert alert-danger text-center">{{ session('register_role') . ' ' . 'registered ' .'but biography not updated... please update user biography...if this issue continues contact our support team'}}</div>
                @endif

                @if( session()->exists('userNotRegistered') )
                        <div class="alert alert-danger text-center">{{ session('register_role') . ' not created due to system error try again'}}</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">{{ 'Register' . ' ' . session('register_role') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('register/' .session('register_role') ) }}" enctype="multipart/form-data">
                            @csrf
                            
                        
                            {{--
                        
                                registering students does not NECESSARILY require email or phone number 
                                this is separated using the register_role session in the input tag

                                authentication is done by registration number or email

                            --}}

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" <?php if( session('register_role') !== 'student'){echo 'required' ;}?> autocomplete="email">

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
                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" <?php if( session('register_role') !== 'student'){echo 'required' ;}?>>


                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            

                            
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                                    
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                

                            <div class="form-group row">
                                <label for="birthday" class="col-md-4 col-form-label text-md-right ">{{ __('birthday') }}</label>

                                <div class="col-md-6">
                                    <input id="birthday" type="date" class="form-control  @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}" required>
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
                                    <input id="nationality" type="text" class="form-control  @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}" required>
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
                                    <input id="state_of_origin" type="text" class="form-control  @error('state_of_origin') is-invalid @enderror" name="state_of_origin" value="{{ old('state_of_origin') }}" required>
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
                                            <option value="male" @if( old ('gender') == 'male' ) selected = "selected" @endif>male</option>
                                            <option value="female" @if( old ('gender') == 'female' ) selected = "selected" @endif>female</option>
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

                                        <select name="religion" id="religion" class = "form-control  @error('religion') is-invalid @enderror" required>
                                            <option value="">select religion</option>
                                            <option value="christian"  @if( old ('religion') == 'christian' ) selected = "selected" @endif>christian</option>
                                            <option value="islam" @if( old ('religion') == 'islam' ) selected = "selected" @endif>islam</option>
                                            <option value="others" @if( old ('religion') == 'others' ) selected = "selected" @endif>others</option>
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
                                    <input id="address" type="text" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                            </div>
                            


                            @if( session('register_role') == 'student') {{-- special student form --}}

                

                                <div class="form-group row">
                                    <label for="section_id" class="col-md-4 col-form-label text-md-right">{{ __('class-group-section') }}</label>

                                    <div class="col-md-6">

                                        <select name="section_id" id="section_id" class = "form-control  @error('section_id') is-invalid @enderror" required>
                                                <option value="">select class</option>
                                            
                                            @foreach ( $sections as $section)

                                                <option value="{{$section->id}}">{{$section->schoolClass->name .' : ' .$section->schoolClass->group . ' : ' .$section->name}}</option>
                                                
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
                                                <option value="{{$schoolSession->id}}">{{$schoolSession->name}}</option>
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
                                        <input id="father_name" type="text" class="form-control  @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') }}" required autocomplete="father_name">
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
                                        <input id="father_phone" type="text" class="form-control  @error('father_phone') is-invalid @enderror" name="father_phone" value="{{ old('father_phone') }}">
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
                                        <input id="mother_name" type="text" class="form-control  @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name') }}" required autocomplete="mother_name">
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
                                        <input id="mother_phone" type="text" class="form-control  @error('mother_phone') is-invalid @enderror" name="mother_phone" value="{{ old('mother_phone') }}">
                                        @error('mother_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>


                            @endif {{-- special student form --}}

                            @if( session('register_role') != 'student') {{-- special staff form --}}

                                
                                <div class="form-group row">

                                    <label for="qualification" class="col-md-4 col-form-label text-md-right">{{ __('qualification') }}</label>

                                    <div class="col-md-6">
                                        <input id="qualification" type="text" class="form-control  @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" required>
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
                                        <input id="next_of_kin" type="text" class="form-control  @error('next_of_kin') is-invalid @enderror" name="next_of_kin" value="{{ old('next_of_kin') }}" required>
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
                                        <input id="next_of_kin_phone" type="text" class="form-control  @error('next_of_kin_phone') is-invalid @enderror" name="next_of_kin_phone" value="{{ old('next_of_kin_phone') }}" required>
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
                                        <input id="referee" type="text" class="form-control  @error('referee') is-invalid @enderror" name="referee" value="{{ old('referee') }}" required>
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
                                        <input id="referee_phone" type="text" class="form-control  @error('referee_phone') is-invalid @enderror" name="referee_phone" value="{{ old('referee_phone') }}" required>
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
                                        <input id="previous" type="text" class="form-control  @error('previous') is-invalid @enderror" name="previous" value="{{ old('previous') }}" required>
                                        @error('previous')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>


                            @endif {{-- special staff form --}}

                            <div class="form-group row">

                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('choose image') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control  @error('image') is-invalid @enderror" name="image">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class = "row justify-content-center">
            <div class = "card" style = "width: 18rem; ">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{url('register/student')}}" class="btn btn-primary btn-lg  btn-block  active" role="button" aria-pressed="true">register student</a>                        
                    </li>
               
                    <li class="list-group-item">
                        <a href="{{url('register/teacher')}}" class="btn btn-primary btn-lg btn-block  active" role="button" aria-pressed="true">register teacher</a>                        
                    </li>
                </ul>
            </div>
        </div>

    @endif 
</div>
@endsection
