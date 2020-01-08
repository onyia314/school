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
                <div class="card-header" style="padding-left:0; padding-right:0;">Dashboard</div>

                    @if ( $users->count() )

                         <div><input type="text" name="search" id="search" placeholder="search"></div>

                        @if($role == 'student')
                            @include('users.students.table-list')
                        @elseif($role == 'teacher')
                            @include('users.teachers.table-list')
                        @elseif($role == 'admin')
                            @include('users.admin.table-list')
                        @endif

                    @else

                        @if ($active == 1)
                            <h3>no active {{$role}} in the school yet</h3>
                        @elseif($active == 0)
                            <h3>no in-active {{$role}} in the school yet</h3>
                        @else
                            <h3>invalid selection</h3>
                        @endif
                        
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
