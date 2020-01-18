@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">

        @include('include.left-menu')
        
        <div class="col-md-9">
            <div class="card">

            <div class="card-header text-center" style="padding-left:0; padding-right:0;">
            <h5>
                {{
                    $fee->semester->schoolSession->session_name .' '
                    .$fee->semester->semester_name
                }}
            </h5>
            <h5>
                {{
                $fee->section->schoolClass->class_name . ' '
                .$fee->section->schoolClass->class_group
                .$fee->section->section_name 
                }}
            </h5>
            </div>

            @if( $payments->count() )

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">payment id</th>
                            <th scope="col">fee name</th>
                            <th scope="col">fee amount</th>
                            <th scope="col">student name</th>
                            <th scope="col">student reg</th>
                            <th scope="col">reference</th>
                            <th scope="col">amount paid</th>
                            <th scope="col">payment mode</th>
                            <th scope="col">payment date</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <th scope="row">{{$payment->id}}</th>
                                <th scope="row">{{$payment->fee->fee_name}}</th>
                                <th scope="row">{{$payment->fee->amount}}</th>
                                <th scope="row">{{$payment->student->name}}</th>
                                <th scope="row">{{$payment->student->reg_number}}</th>
                                <th scope="row">{{$payment->reference}}</th>
                                <th scope="row">{{$payment->amount_paid}}</th>
                                <th scope="row">{{$payment->payment_mode}}</th>
                                <th scope="row">{{$payment->created_at}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>{{$payments->links()}}</div>

        @else
        <h3>no student in this section has paid for {{$fee->fee_name}}</h3>
        @endif

            </div>
        </div>
    </div>
</div>
@endsection
