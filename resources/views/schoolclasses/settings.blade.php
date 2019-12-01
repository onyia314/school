@extends('layouts.app')

@section('content')

<script>

    document.addEventListener('DOMContentLoaded' , function(){

       var add =  document.getElementById('addSection');
       add.addEventListener('submit' , function(e){
            e.preventDefault();

            document.getElementById('msg').style.color = 'black';
            document.getElementById('msg').innerHTML = 'please wait.....'

            var id = document.getElementById('class_id').value;
            var group = document.getElementById('class_group').value;
            var section = document.getElementById('name').value;
            var token = document.getElementsByName('_token')[0].value;

            var data = {
                name: section,
                class_id: id,
                class_group: group,
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

                        case 'class_exists':
                            var msg = response.class_exists;
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

                        <?php 

                                foreach ($class as $value) {
                                    $class_name = $value['name'];
                                    $class_id = $value['id'];
                                    $class_group = $value['group'];
                                }

                        ?>

                            <form id = "addSection" method="POST" action=" {{ url('settings/addsection') }} ">
                                @csrf
                                
                                {{-- the form submition for this was done with Ajax --}}
                                
                                <div class="form-group row">

                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('add section') }}</label>
    
                                    <div class="col-md-6">
                                        <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}"  autocomplete="name" autofocus placeholder="A,B,C...Z">        
                                    </div>
                                </div>

                                <div class="form-group row">
        
                                        <div class="col-md-6">
                                            <input type="hidden" name = "class_group" id = "class_group" value = "{{$class_group}}">
                                        </div>
                                </div>

                                <div class="form-group row">
        
                                        <div class="col-md-6">
                                
                                            <input type="hidden" name = "class_id" id = "class_id" value = "{{$class_id}}">
                             
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
                
                    {{ $class_name .' '.$class_group }}
                
            </h3>
            <div class="card-body">
                <ul class="nav flex-column">
                    @foreach ($class as $value)

                        @foreach ($value['sections'] as $sections)
                        <a>{{ $sections->name}}<a>
                        @endforeach
            
                    @endforeach
                </ul>

                <div>
                    <button type="button" class = "btn btn-primary btn-block "data-toggle="modal" data-target="#myModal" data-backdrop="static">add section</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

