@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            
        <div class="alert text-center"> 
            <h2>
            {{$section->schoolClass->class_name .'  ' .$section->schoolClass->group .' ' .$section->section_name}}
            </h2>
        </div>
                    @if ( $fees->count() )
                        
                        <div class = "table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    @if(Auth::user()->role == 'accountant')
                                    <th scope="col">edit details</th>
                                    @endif
                                    <th scope="col">fee id</th>
                                    <th scope="col">fee name</th>
                                    <th scope="col">amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($fees as $fee)
                                        <tr>
                                            <th scope="row">{{$fee->id}}</th>
                                            @if(Auth::user()->role == 'accountant')
                                            <td><a class = "btn btn-primary" href="">edit</a></td>
                                            @endif
                                            <td>{{$fee->fee_name}}</td>
                                            <td>{{$fee->amount}}</td>
                                        </tr>   
                                        
                                    @endforeach
                                </tbody> 
                            </table> 
                        </div>     
                    @else
                        <h3>no fee has been made for this section in this semester</h3>
                    @endif
                    
          
        </div>
    </div>
</div>
@endsection
