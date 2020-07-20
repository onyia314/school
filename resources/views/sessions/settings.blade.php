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

            var general = document.getElementsByClassName('general');
            for(var i = 0; i < general.length ; i++ ){
                general[i].innerHTML = '';
            }
            
            document.getElementById('msg').style.color = 'black';
            document.getElementById('msg').innerHTML = 'please wait.....'

            var semester = document.getElementById('semester_name').value;
            var id = document.getElementById('session_id').value;
            var startOfSemester = document.getElementById('start_date').value;
            var endOfSemester = document.getElementById('end_date').value;
            var token = document.getElementsByName('_token')[0].value;
            var semester_status = document.getElementById('status').value;

            var data = {
                semester_name: semester,
                session_id: id,
                start_date: startOfSemester,
                end_date: endOfSemester,
                status: semester_status,
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

                var responses = JSON.parse(xhr.responseText);

                //uncomment this to view the structure of the response

               // console.log(responses);
                
                for(var response in responses){

                    switch (response) {

                        case 'error':

                            for(var prop in responses.error){

                                switch (prop) {
                                    case 'semester_name':
                                    var msg = responses.error.semester_name.join('.')
                                    document.getElementById('semester_name_msg').innerHTML = msg;
                                    break;

                                    case 'start_date':
                                    var msg = responses.error.start_date.join('.')
                                    document.getElementById('start_date_msg').innerHTML = msg ;
                                    break;

                                    case 'end_date':
                                    var msg = responses.error.end_date.join('.')
                                    document.getElementById('end_date_msg').innerHTML = msg ;
                                    break;

                                    case 'session_id':
                                    var msg = responses.error.session_id.join('.')
                                    document.getElementById('session_id_msg').innerHTML = msg ;
                                    break;

                                    case 'status':
                                    var msg = responses.error.status.join('.')
                                    document.getElementById('status_msg').innerHTML = msg ;
                                    break;
                                
                                    default:
                                    alert('switch statement doesnt match any result');
                                    break;
                                }
                            }

                            document.getElementById('msg').innerHTML = ''
                        break;

                        case 'success':
                            var msg = responses.success;
                            document.getElementById('msg').innerHTML = msg;
                            document.getElementById('msg').style.color = 'green';
                            break;

                        case 'semester_exists':
                            var msg = responses.semester_exists;
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

                            <form id = "addSemester" method="POST" action=" {{ url('settings/addsemester') }} ">
                                @csrf
                                
                                {{-- the form submition for this was done with Ajax --}}
                                
                                <div class="form-group row">

                                    <label for="semester_name" class="col-md-4 col-form-label text-md-right">{{ __('add semester') }}</label>
    
                                    <div class="col-md-6">
                                        <input id="semester_name" name="semester_name" type="text" class="form-control" autocomplete="semester_name" autofocus placeholder="1st , 2nd , 3rd">  
                                        <span>
                                            <strong class = "general" id = "semester_name_msg" style="color:red"></strong>
                                        </span>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">
        
                                        <div class="col-md-6">
                                            <input type="hidden" name = "session_id" id = "session_id" value = "{{$schoolSession->id}}">
                                            <span>
                                                <strong class = "general" id = "session_id_msg" style="color:red"></strong>
                                            </span>
                                        </div>
                                        
                                </div>

                                <div class="form-group row">
                                    <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('add start date') }}</label>
    
                                    <div class="col-md-6">
                                        <input name="start_date" id="start_date" type="date" class="form-control" placeholder="yyyy-mm-dd">
                                        <span>
                                            <strong class = "general" id = "start_date_msg" style="color:red"></strong>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('add end date') }}</label>
    
                                    <div class="col-md-6">
                                        <input name="end_date" id="end_date" type="date" class="form-control" placeholder="yyyy-mm-dd">
                                        <span>
                                            <strong class = "general" id = "end_date_msg" style="color:red"></strong>
                                        </span>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">
                                    
                                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('select status') }}</label>

                                    <div class="col-md-6">
                                        <select name="status" id="status" class="form-control">
                                            <option value="">status</option>
                                            <option value="open">open</option>
                                            <option value="locked">locked</option>
                                        </select>

                                        <span>
                                            <strong class = "general" id = "status_msg" style="color:red"></strong>
                                        </span>
                                    </div>

                                </div>

                                <div class="form-group row">
        
                                    <div style="margin-left:auto; margin-right:auto;">
                            
                                        <span>
                                            <strong class = "general" id = "msg"></strong>
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
                
                    {{ $schoolSession->session_name }}
                
            </h3>
            <div class="card-body">

                    @if( $schoolSession->semesters->count() )
                        <ul class="nav flex-column">
                            @foreach ($schoolSession->semesters as $semester)
                                <li class = "nav-item">
                                    <strong>{{ $semester->semester_name}}</strong>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h3>no semester has been made for this section</h3>
                    @endif
                
                <div>
                    <button type="button" class = "btn btn-primary btn-block "data-toggle="modal" data-target="#myModal" data-backdrop="static">add semester</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

