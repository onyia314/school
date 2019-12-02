@extends('layouts.app')

@section('content')


<script>

        document.addEventListener('DOMContentLoaded' , function(){
    
           var add =  document.getElementById('addFee');
           add.addEventListener('submit' , function(e){
                e.preventDefault();

                document.getElementById('msg').style.color = 'black';
                document.getElementById('msg').innerHTML = 'please wait.....'

                var fee = document.getElementById('fee_name').value;
                var id = document.getElementById('semester_id').value;
                var fee_amount = document.getElementById('amount').value;
                var token = document.getElementsByName('_token')[0].value;
    
                var data = {
                    fee_name: fee,
                    semester_id: id,
                    amount: fee_amount,
                    _token: token
                }
               
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = myCallback;
                xhr.open('POST', "{{ url('fees/addfee') }}", true);
                xhr.setRequestHeader('Content-Type' , 'application/json');
                xhr.send(JSON.stringify(data));
    
                
                function myCallback() {
                    if (xhr.readyState < 4) {
                         return; // not ready yet
                    }
    
                    
                    if (xhr.status !== 200) {
                        alert('Error!'); // the HTTP status code is not OK
                        return;
                    }
    
                    var response = JSON.parse(xhr.responseText);
    
                    //uncomment this to view the structure of the response
    
                    //console.log(response);
                    
                    for(var prop in response){
    
                        switch (prop) {
                            case 'error':
                                var msg = response.error.name.join();
                                document.getElementById('msg').innerHTML = msg;
                                document.getElementById('msg').style.color = 'red';
                                break;
    
                            case 'success':
                                var msg = response.success;
                                document.getElementById('msg').innerHTML = msg;
                                document.getElementById('msg').style.color = 'green'; 
                                break;
    
                            case 'fee_exists':
                                var msg = response.fee_exists;
                                document.getElementById('msg').innerHTML = msg;
                                document.getElementById('msg').style.color = 'red';
                                break;
                        
                            default:
                                alert('switch statement doesnt match any result');
                                break;
                        }
                    }
                }
    
                
           })
        })
    
    </script>

<div class="container">

    <div class="modal" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">add fee</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                            <form id = "addFee" method="POST" action=" {{ url('fees/addfee') }} ">
                                @csrf
                                
                                {{-- the form submition for this was done with Ajax --}}
                                
                                <div class="form-group row">

                                    <label for="fee_name" class="col-md-4 col-form-label text-md-right">{{ __('add fee') }}</label>

                                    <div class="col-md-6">
                                        <input id="fee_name" name="fee_name" type="text" class="form-control" value="{{ old('fee_name') }}"  autocomplete="fee_name" autofocus placeholder=" eg. tuition, accomodation">
                                        
                                    </div>
                                    
                                </div>

                                <div class="form-group row">

                                        <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('amount') }}</label>
    
                                        <div class="col-md-6">
                                            <input id = "amount" name = "amount" type="text"  class = "form-control" value = "{{old('amount')}}">
                                        </div>
                                        
                                </div>

                                <div class="form-group row">
    
                                        <div class="col-md-6">
                                        <input id = "semester_id" name = "semester_id" type="hidden"  class = "form-control" value = "{{$semester_id}}">
                                        </div>
                                        
                                </div>

                                <div class="form-group row">
        
                                    <div style="margin-left:auto; margin-right:auto;">
                            
                                        <span role="alert">
                                            <strong id = "msg"></strong>
                                        </span>
                                    
                                    </div>

                                 </div>
    
    
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Add fee') }}
                                        </button>
                                    </div>
                                </div>
    
                            </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
    </div>
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            <div class="card">
            <h3 class="card-header text-center">
                
                    
                
            </h3>
            <div class="card-body">
                <ul class="nav flex-column">
                   
                </ul>

                <div>
                    <button type="button" class = "btn btn-primary btn-block "data-toggle="modal" data-target="#myModal" data-backdrop="static">add fee</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

