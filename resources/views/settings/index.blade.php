@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">

        @include('include.left-menu')
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                        <ul class="nav flex-column">

                                    <li class="nav-item">
                                    <a class="nav-link btn btn-block" href="{{ url('settings/addclass') }}"><span
                                          class="nav-link-text">create class</span></a>
                                    </li>

                                    <li class="nav-item">
                                    <a class="nav-link btn btn-block" href="{{ url('settings/addsession')}}"><span
                                          class="nav-link-text">create session</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link btn btn-block" href="{{ url('settings/viewsessions')}}"><span
                                              class="nav-link-text">create semester</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link btn btn-block" href="{{ route('section.addcourse') }}"><span
                                              class="nav-link-text">create courses</span></a>
                                    </li>

                                    <li class="nav-item">
                                    <a class="nav-link btn btn-block" href="{{url('register/student')}}"><span
                                          class="nav-link-text">add student</span></a>
                                    </li>
        
                                    <li class="nav-item">
                                      <a class="nav-link btn btn-block" href="{{url('register/teacher')}}"><span
                                          class="nav-link-text">add teacher</span></a>
                                    </li>
                                    
                                    <li class="nav-item">
                                      <a class="nav-link btn btn-block" href=""><span
                                          class="nav-link-text">add accountant</span></a>
                                    </li>

                                    <li class="nav-item">
                                            <a class="nav-link btn btn-block" href=""><span
                                                class="nav-link-text">add liberian</span></a>
                                    </li>

                                    <li class="nav-item">
                                            <a class="nav-link btn btn-block" href=""><span
                                                class="nav-link-text">add others</span></a>
                                    </li>

                                    <li class="nav-item">
                                            <a class="nav-link btn btn-block" href=""><span
                                                class="nav-link-text">upload/write notice</span></a>
                                    </li>

                                    <li class="nav-item">
                                            <a class="nav-link btn btn-block" href=""><span
                                                class="nav-link-text">upload / write event</span></a>
                                    </li>
    
                            </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
