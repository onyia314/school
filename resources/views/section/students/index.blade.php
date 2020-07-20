@extends('layouts.app')
@section('content')
<script>
    document.addEventListener('DOMContentLoaded' , () => {

        

        /* document.getElementById('search').addEventListener('blur' , (e) => {

            var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = myCallback;
                xhr.open('get', "{{ url( 'users/view/students/status/1') }}" + '/' + e.target.value , true);
                xhr.send();

                
                function myCallback() {
                    if (xhr.readyState < 4) {
                        return; // not ready yet
                    }

                    
                    if (xhr.status !== 200) {
                    alert('Error!'); // the HTTP status code is not OK
                    return;
                    }

                    var response = JSON.parse(xhr.responseText);  
                    var myHtml = response.html;
                    document.write(myHtml);
                }
                
        }); */
    })
</script>
<div class="container">
    <div class="row justify-content-center">

        @include('include.left-menu')
        
        <div class="col-md-9">
            <div class="card">
            <div class="card-header text-center" style="padding-left:0; padding-right:0;"><h3></h3></div>
                    @if ( $users->count() )

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">edit</th>
                                    <th scope="col">promote/demote</th>
                                    <th scope="col">name</th>
                                    <th scope="col">reg</th>
                                    <th scope="col">section</th>
                                    <th scope="col">class</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @foreach ($users as $student)
                                    <tr>
                                        <th scope="row">{{$student->id}}</th>
                                        <th scope="row">
                                            <a class = "btn btn-primary"href="{{route('user.edit' , ['id' => $student->id])}}">edit</a>
                                        </th>
                                        <th scope="row">
                                            <a class = "btn btn-primary"href="">promote/demote</a>
                                        </th>
                                        <th>{{$student->name}}</th>
                                        <th>{{$student->reg_number}}</th>
                                        <th>{{$student->section->section_name}}</th>
                                        <th>{{$student->section->SchoolClass->class_name .' ' 
                                        .$student->section->SchoolClass->group}}
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>{{$users->links()}}</div>
                    @else
                        <h3>no active student in the selected section</h3>  
                    @endif

            </div>
        </div>
    </div>
</div>
@endsection
