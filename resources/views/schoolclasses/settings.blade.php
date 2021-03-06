@extends('layouts.app')
    {{--
        here you can add sections (arm) for each class_id    
    --}}
@section('content')

@if ($class)
    

    <script>

        document.addEventListener('DOMContentLoaded' , function(){

        var add =  document.getElementById('addSection');
        add.addEventListener('submit' , function(e){
                e.preventDefault();

                var general = document.getElementsByClassName('general');
                for(var i = 0; i < general.length ; i++ ){
                    general[i].innerHTML = '';
                }
                
                document.getElementById('msg').style.color = 'black';
                document.getElementById('msg').innerHTML = 'please wait.....'

                var id = document.getElementById('class_id').value;
                var section = document.getElementById('section_name').value;
                var token = document.getElementsByName('_token')[0].value;

                var data = {
                    section_name: section,
                    class_id: id,
                    _token: token
                }
            
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = myCallback;
                xhr.open('POST', "{{ url('settings/addsection') }}", true);
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

                    var responses = JSON.parse(xhr.responseText);

                    //uncomment this to view the structure of the response

                    //console.log(responses);
                    
                    for(var prop in responses){

                        switch (prop) {

                            case 'error':
                                for(var prop in responses.error){

                                    switch (prop) {
                                        case 'section_name':
                                        var msg = responses.error.section_name.join('.')
                                        document.getElementById('section_name_msg').innerHTML = msg;
                                        break;

                                        case 'class_id':
                                        var msg = responses.error.class_id.join('.')
                                        document.getElementById('class_id_msg').innerHTML = msg ;
                                        break;

                                        default:
                                        alert('switch statement doesnt match any result');
                                        break;
                                    }
                            }
                           document.getElementById('msg').innerHTML = '';
                           break;
                                
                            case 'success':
                                var msg = responses.success;
                                document.getElementById('msg').innerHTML = msg;
                                document.getElementById('msg').style.color = 'green';
                                break;

                            case 'class_exists':
                                var msg = responses.class_exists;
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
                        <h5 class="modal-title">add a section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">

                                <form id = "addSection" method="POST" action=" {{ url('settings/addsection') }} ">
                                    @csrf
                                    
                                    {{-- the form submition for this was done with Ajax --}}
                                    
                                    <div class="form-group row">

                                        <label for="section_name" class="col-md-4 col-form-label text-md-right">{{ __('add section') }}</label>
        
                                        <div class="col-md-6">
                                            <input id="section_name" name="section_name" type="text" class="form-control" value="{{ old('section_name') }}"  autocomplete="section_name" autofocus placeholder="A,B,C...Z">        
                                            <span>
                                                <strong  class="general" id = "section_name_msg" style="color:red"></strong>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-md-6">                           
                                            <input type="hidden" name = "class_id" id = "class_id" value = "{{$class->id}}">
                                            <span>
                                                <strong class="general" id = "class_id_msg" style="color:red"></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div style="margin-left:auto; margin-right:auto;">
                                            <span role="alert">
                                                <strong class="general" id = "msg"></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                {{ __('Add add section') }}
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
                    {{ $class->class_name .' '.$class->group }}  
                </h3>
                <div class="card-body">

                    @if ( $class->sections->count() )
                    <ul class="nav flex-column">
                
                        @foreach ($class->sections as $section)
                            <a>{{ $section->section_name}}<a>
                        @endforeach
                
                    </ul>

                    @else
                        <h3>No section has been made for this class</h3>
                    @endif
                    
                    <div>
                        <button type="button" class = "btn btn-primary btn-block "data-toggle="modal" data-target="#myModal" data-backdrop="static">add section</button>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>
    @else
    <div class="row justify-content-center">

        @include('include.left-menu')
        <div class="col-md-8">
            <h3>this class does not exist</h3>
        </div>
        
    </div>
@endif
@endsection