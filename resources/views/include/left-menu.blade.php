<div class="col-md-3">
        <div class="card">
            <div class="card-header text-center">Dashboard</div>

            <div class="card-body">
                    <ul class="nav flex-column">
                        
                        @if(Auth::user()->role == 'master')
                              <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href="{{url('register/admin')}}"><span
                                    class="nav-link-text">add admin</span></a>
                              </li>

                              <li class="nav-item mb-1">
                                    <div class="dropdown">
                                          <a class="btn btn-block btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLinkAdmins" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            view admins
                                          </a>
                                        
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkAdmins">
                                          <a class="dropdown-item" href="{{route('view.users' , ['role' => 'admin' , 'active' => 1] )}}">active admins</a>
                                          <a class="dropdown-item" href="{{route('view.users' , ['role' => 'admin' , 'active' => 0] )}}">in-active admins</a>
                                          </div>
                                        </div>
                              </li>
  
                        @endif

                        @if(Auth::user()->role == 'admin')

                            <li class="nav-item mb-1">
                              <div class="dropdown">
                                    <a class="btn btn-block btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Attendance
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('selectsection.attendance') }}">student daily attendace</a>
                                    <a class="dropdown-item" href="{{route('create.staff.attendance')}}">staff</a>
                                    </div>
                                  </div>
                            </li>

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href="{{ url('settings/viewclasses') }}"><span
                                  class="nav-link-text">clases and groups</span></a>
                            </li>

                            <li class="nav-item mb-1">
                            <a class="nav-link btn btn-block btn-primary" href="{{url('settings/viewsessions')}}"><span
                                  class="nav-link-text">sessions</span></a>
                            </li>

                            <li class="nav-item mb-1">
                              <div class="dropdown">
                                    <a class="btn btn-block btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLinkStudents" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      students
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkStudents">
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'student' , 'active' => 1] )}}">active students</a>
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'student' , 'active' => 0] )}}">in-active students</a>
                                    </div>
                                  </div>
                            </li>

                            <li class="nav-item mb-1">
                              <div class="dropdown">
                                    <a class="btn btn-block btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLinkTeachers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      teachers
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkTeachers">
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'teacher' , 'active' => 1] )}}">active teachers</a>
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'teacher' , 'active' => 0] )}}">in-active teachers</a>
                                    </div>
                                  </div>
                            </li>

                            <li class="nav-item mb-1">
                              <div class="dropdown">
                                    <a class="btn btn-block btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLinkAccountant" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Accountant
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkAccountant">
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'accountant' , 'active' => 1] )}}">active Accountant</a>
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'accountant' , 'active' => 0] )}}">in-active Accountants</a>
                                    </div>
                                  </div>
                            </li>

                            <li class="nav-item mb-1">
                              <div class="dropdown">
                                    <a class="btn btn-block btn-secondary dropdown-toggle block" href="#" role="button" id="dropdownMenuLinkLibrarian" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Librarian
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkLibrarian">
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'librarian' , 'active' => 1] )}}">active Librarian</a>
                                    <a class="dropdown-item" href="{{route('view.users' , ['role' => 'librarian' , 'active' => 0] )}}">in-active Librarian</a>
                                    </div>
                                  </div>
                            </li>

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href="{{route('settings')}}"><span
                                    class="nav-link-text">Academic settings</span></a>
                              </li> 

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                    class="nav-link-text">Exams</span></a>
                              </li>
                            
                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">Grade/results</span></a>
                            </li>

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">others staff</span></a>
                            </li>                            
                            

                            <li class="nav-item mb-1">
                            <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">generate fees</span></a>
                            </li> 

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">syllabules</span></a>
                            </li> 

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">notices</span></a>
                            </li>

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">events</span></a>
                            </li>

                            <li class="nav-item mb-1">
                              <a class="nav-link btn btn-block btn-primary" href=""><span
                                  class="nav-link-text">library</span></a>
                            </li>

                        @endif

                        @if (Auth::user()->role == 'teacher')
                            <li class="nav-item mb-1">
                            <a class="nav-link btn btn-block btn-primary" href="{{route('teacher.viewcourses')}}"><span
                                  class="nav-link-text">my courses</span></a>
                            </li>
                        @endif

                        @if (Auth::user()->role == 'student')
                            <li class="nav-item mb-1">
                            <a class="nav-link btn btn-block btn-primary" href="{{route('student.courses')}}"><span
                                  class="nav-link-text">my courses</span></a>
                            </li>
                        @endif

                    </ul>
            </div>
        </div>
</div>