@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
        
            @if ( session()->exists('attTaken') && session()->exists('staffsDailyAttTaken'))
                <div class="alert alert-success text-center">Attendance taken</div>
            @endif

            @if ( !session()->exists('attTaken') && session()->exists('staffsDailyAttTaken'))
                <div class="alert alert-danger text-center">today's staff Attendance has already been taken</div>
            @endif

            @if (session()->exists('semesterLocked'))
                <div class="alert alert-danger text-center">oops semester is Locked for taking attendance</div>
            @endif

            @if ( $staffs->count() )
                        
                        <div class = "table-responsive">

                            @if( !( session()->exists('staffsDailyAttTaken') ) )
                            <form method="POST" action="{{route('staff.attendance')}}">
                                @csrf
                                <input type="hidden" class  = "form-control" name="semester_id" value="{{$semester_id}}">
                                <div>
                                    @error('semester_id')  
                                            <strong style="color:red;">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div>
                                    @if( $errors->has('staffs.*') )
                                        @foreach ($errors->get('staffs.*') as $messages)
                                            @foreach ($messages as $message)
                                                <div><span style="color:red;">{{$message}}</span></div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                            
                                <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">staff id</th>
                                            <th scope="col">staff name</th>
                                            <th scope="col">role</th>
                                            @if( !( session()->exists('staffsDailyAttTaken') ))
                                                <th scope="col">present</th>
                                            @endif
                                            
                                            <th scope="col">total semester attendance</th>
                                            <th scope="col">total attended</th>
                                            <th scope="col">total missed</th>
                                            <th scope="col">% attended</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                
                                                @foreach ($staffs as $staff)
                                                    <tr>
                                                        <th scope="row">{{$staff->id}}</th>
                                                        <th>{{$staff->name}}</th>
                                                        <th>{{$staff->role}}</th>

                                                        @if( !( session()->exists('staffsDailyAttTaken') ))
                                                            <th>
                                                                <input type="checkbox" name = "present[]" value = "{{$staff->id}}" class = "present">
                                                                <input type="hidden" name = "staffs[]" value = "{{$staff->id}}">
                                                            </th>
                                                        @endif
                                                    
                                                        <th>{{ $attPresent[$staff->id] + $attAbsent[$staff->id] }}</th>
                                                        <th>{{$attPresent[$staff->id]}}</th>
                                                        <th>{{$attAbsent[$staff->id]}}</th>
                                                        <th>
                                                            @php
                                                                //to avoid division by zero error
                                                                if( ($attPresent[$staff->id] + $attAbsent[$staff->id]) == 0 ){
                                                                    echo '0';
                                                                }else{
                                                                    echo ( ($attPresent[$staff->id]) / ($attPresent[$staff->id] + $attAbsent[$staff->id]) ) * 100;
                                                                }
                                                            @endphp
                                                        </th>
                                                    </tr>
                                                @endforeach
                                                
                                        </tbody> 
                                    </table>

                                    <div>
                                        @error('present')  
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    
                             @if (!( session()->exists('staffsDailyAttTaken') ))
                                <button type="submit" class="btn btn-primary">
                                        {{ __('take attendance') }}
                                </button>
                            </form>
                             @endif
                                
                            
                        </div>     
                    @else
                        <h3>no staff made yet</h3>
                    @endif
            
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded' , () =>{ 
        var present = document.getElementsByClassName('present');
        for(var i = 0; i < present.length ; i++){
            present[i].checked = true;
        }
    });
</script>
@endsection
