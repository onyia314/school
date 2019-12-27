<div class="col-md-3">
        <div class="card">
            <div class="card-header text-center">Dashboard</div>

            <div class="card-body">
                    <ul class="nav flex-column">

                        @if(Auth::user()->role == 'admin')

                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">Exams</span></a>
                            </li>

                            <li class="nav-item">
                              <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Attendance
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('selectsection.attendance') }}">student daily attendace</a>
                                    <a class="dropdown-item" href="{{route('create.staff.attendance')}}">staff</a>
                                    </div>
                                  </div>
                            </li>
                            
                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">Grade/results</span></a>
                            </li>

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href="{{ url('settings/viewclasses') }}"><span
                                  class="nav-link-text">clases and groups</span></a>
                            </li>

                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href="{{url('settings/viewsessions')}}"><span
                                  class="nav-link-text">sessions</span></a>
                            </li>


                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">student</span></a>
                            </li>

                             <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">teachers</span></a>
                            </li>

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">others staff</span></a>
                            </li>                            
                            
                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href="{{route('settings')}}"><span
                                  class="nav-link-text">Academic settings</span></a>
                            </li> 

                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href="{{ url('fees/viewsessions')}}"><span
                                  class="nav-link-text">generate fees</span></a>
                            </li> 

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">syllabules</span></a>
                            </li> 

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">notices</span></a>
                            </li>

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">events</span></a>
                            </li>

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">library</span></a>
                            </li>

                        @endif

                        @if (Auth::user()->role == 'teacher')
                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href="{{route('teacher.viewcourses')}}"><span
                                  class="nav-link-text">my courses</span></a>
                            </li>
                        @endif

                        @if (Auth::user()->role == 'student')
                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href="{{route('student.viewcourses')}}"><span
                                  class="nav-link-text">my courses</span></a>
                            </li>
                        @endif

                    </ul>
            </div>
        </div>
</div>