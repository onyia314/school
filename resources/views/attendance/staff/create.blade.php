@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
        
            @if ( session()->exists('attTaken') && session()->exists('staffsDayAttTaken'))
                <div class="alert alert-success text-center">Attendance taken</div>
            @endif

            @if ( !session()->exists('attTaken') && session()->exists('staffsDayAttTaken'))
                <div class="alert alert-danger text-center">today's staff Attendance has already been taken</div>
            @endif

            @if (session()->exists('semesterClosed'))
                <div class="alert alert-danger text-center">oops semester is closed for taking attendance</div>
            @endif

            @if ( $staffs->count() )
                        
                        <div class = "table-responsive">

                            @if( !( session()->exists('stsffsDayAttTaken') ) )

                            <form method="POST" action="{{route('staff.attendance')}}">

                                @csrf
                                <input type="hidden" name="semester_id" value="{{$semester_id}}">
                                <input type="hidden" name="takenBy_id" value="{{$takenBy_id}}">
                            @endif
                            
                                <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">staff id</th>
                                            <th scope="col">staff name</th>
                                            <th scope="col">role</th>
                                            @if( !( session()->exists('staffsDayAttTaken') ))
                                                <th scope="col">present</th>
                                            @endif
                                            
                                            <th scope="col">total semester attendance</th>
                                            <th scope="col">total attended</th>
                                            <th scope="col">total missed</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                
                                                @foreach ($staffs as $staff)
                                                    <tr>
                                                        <th scope="row">{{$staff->id}}</th>
                                                        <th>{{$staff->name}}</th>
                                                        <th>{{$staff->role}}</th>

                                                        @if( !( session()->exists('staffsDayAttTaken') ))
                                                            <th>
                                                                <input type="checkbox" name = "present[]" value = "{{$staff->id}}" class = "present">
                                                                <input type="hidden" name = "users[]" value = "{{$staff->id}}">
                                                            </th>
                                                        @endif
                                                    
                                                        <th>{{ $attPresent[$staff->id] + $attAbsent[$staff->id] }}</th>
                                                        <th>{{$attPresent[$staff->id]}}</th>
                                                        <th>{{$attAbsent[$staff->id]}}</th>
                                                    </tr>
                                                @endforeach
                                                
                                        </tbody> 
                                    </table>

                                    <div>
                                        @error('present')  
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </div>

                                    
                             @if (!( session()->exists('staffsDayAttTaken') ))
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
