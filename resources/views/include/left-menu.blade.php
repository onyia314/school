<div class="col-md-4">
        <div class="card">
            <div class="card-header text-center">Dashboard</div>

            <div class="card-body">
                    <ul class="nav flex-column">

                        @if(Auth::user()->role == 'admin')

                            <li class="nav-item">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">Attendance</span></a>
                            </li>

                            <li class="nav-item">
                            <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">Exams</span></a>
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
                    </ul>
            </div>
        </div>
</div>