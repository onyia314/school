@extends('layouts.app')
    {{--
        here you can add semester (term) for each session_id    
    --}}
@section('content')

<script>

    document.addEventListener('DOMContentLoaded' , function(){

       var add =  document.getElementById('addSemester');
       add.addEventListener('submit' , function(e){
            e.preventDefault();

            document.getElementById('msg').style.color = 'black';
            document.getElementById('msg').innerHTML = 'please wait.....'

            var semester = document.getElementById('semester_name').value;
            var id = document.getElementById('session_id').value;
            var token = document.getElementsByName('_token')[0].value;

            var data = {
                semester_name: semester,
                session_id: id,
                _token: token
            }
           
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = myCallback;
            xhr.open('POST', "{{ url('settings/addsemester') }}", true);
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

                        case 'semester_exists':
                            var msg = response.semester_exists;
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
                      <h5 class="modal-title">add a semester</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                        <?php 

                                foreach ($schoolSession as $value) {
                                    $session_name = $value['session_name'];
                                    $session_id = $value['id'];
                            
                                }

                        ?>

                            <form id = "addSemester" method="POST" action=" {{ url('settings/addsemester') }} ">
                                @csrf
                                
                                {{-- the form submition for this was done with Ajax --}}
                                
                                <div class="form-group row">

                                    <label for="semester_name" class="col-md-4 col-form-label text-md-right">{{ __('add semester') }}</label>
    
                                    <div class="col-md-6">
                                        <input id="semester_name" name="semester_name" type="text" class="form-control" value="{{ old('semester_name') }}"  autocomplete="semester_name" autofocus placeholder="1st , 2nd , 3rd">  
                                    </div>
                                </div>

                                <div class="form-group row">
        
                                        <div class="col-md-6">
                                            <input type="hidden" name = "session_id" id = "session_id" value = "{{$session_id}}">
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
                                            {{ __('Add add semester') }}
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
                
                    {{ $session_name }}
                
            </h3>
            <div class="card-body">
                <ul class="nav flex-column">
                    @foreach ($schoolSession as $value)

                        @foreach ($value['semesters'] as $semester)
                        <li class = "nav-item">
                            <strong>{{ $semester->semester_name}}</strong>
                        <a class="btn btn-success" href="{{ url('fees/addfee/' .$semester->id)}}" role="button">fees</a>
                        </li>
                        
                        @endforeach
            
                    @endforeach
                </ul>

                <div>
                    <button type="button" class = "btn btn-primary btn-block "data-toggle="modal" data-target="#myModal" data-backdrop="static">add semester</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

