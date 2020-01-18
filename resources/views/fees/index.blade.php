@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            
        <div class="alert text-center"> 
            <h3>{{$semester->schoolSession->session_name .' ' .$semester->semester_name}}</h3>
            <h3>
            {{$section->schoolClass->class_name .'  ' .$section->schoolClass->group .' ' .$section->section_name}}
            </h3>

            @if(session()->exists('apiError') )
            <div class="alert alert-danger"> system error please check your internet connection and try again later</div>
            @endif

            @if(session()->exists('DbPaymentError') )
            <div class="alert alert-danger"> payment made but we are having issues saving the transaction with the school. pls contact the school accountant</div>
            @endif

            @if(session()->exists('DbPaymentSuccess') )
            <div class="alert alert-success"> payment successful</div>
            @endif

            @if(session()->exists('feeAlreadyPaid') )
            <div class="alert alert-success"> fee already paid</div>
            @endif
        </div>
                    @if ( $fees->count() )
                        
                        <div class = "table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">fee id</th>

                                    @if(Auth::user()->role == 'accountant')
                                    <th scope="col">edit details</th>
                                    <th scope="col">payments</th>
                                    @endif

                                    <th scope="col">fee name</th>
                                    <th scope="col">amount</th>

                                    @if(Auth::user()->role == 'student')
                                    <th scope="col">action</th>
                                    <th scope="col">reference</th>
                                    <th scope="col">amount paid</th>
                                    <th scope="col">date of payment</th>
                                    @endif

                                </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($fees as $fee)

                                        <tr>
                                            <th scope="row">{{$fee->id}}</th>

                                            @if(Auth::user()->role == 'accountant')
                                        <td><a class = "btn btn-primary" href="{{route('edit.fee' , ['fee_id' => $fee->id ])}}">edit</a></td>
                                        <td><a class = "btn btn-primary" href="{{route('view.payments' , ['fee_id' => $fee->id])}}">view payments</a></td>
                                            @endif

                                            <td>{{$fee->fee_name}}</td>
                                            <td>{{$fee->amount}}</td>

                                            @if(Auth::user()->role == 'student')

                                                @if( $fee->payment )
                                                    <td> <button class="btn btn-success">paid</button></td>
                                                    <td>{{$fee->payment->reference}}</td>
                                                    <td>{{$fee->payment->amount_paid}}</td>
                                                    <td>{{$fee->payment->created_at}}</td>
                                                @else

                                                    <td scope="col">
                                                        <form action="{{url('pay')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="section_id" id="section_id" value="{{$section->id}}"/>
                                                            <input type="hidden" name="semester_id" id="semester_id" value="{{$semester->id}}"/>
                                                            <input type="hidden" name="fee_id" id="fee_id" value="{{$fee->id}}"/>
                                                            <button class="btn btn-primary" type="submit">pay</button>
                                                        </form>
                                                    </td>
                                                    <td>null</td>
                                                    <td>null</td>
                                                    <td>null</td>

                                                @endif
                
                                            @endif

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
