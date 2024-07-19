

<div class="container">
    <div class="header row"> 
        <div class = "col-8 col-sm-8 ">
            <div class="logo m-1">
                <span  style = "color:#C12323;">AP</span><span   style = "color:#192126;">GYM</span>
            </div>
        </div>
         <!-- Display different partials based on user role -->
         {{-- @if (Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'trainer')) --}}
         <div class="col-2 col-sm-2 d-flex justify-content-center a-no-underline">
            <li class="nav-item dropdown">

                <a class="nav-link nav-icon d-inline" href="#" data-bs-toggle="dropdown">
                    <span class="material-symbols-outlined blackIcon icons m-1 align-middle">notifications</span>
                </a><!-- End Notification Icon -->
      
                <ul class="p-3 dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                  <li class="dropdown-header">
                    You have 4 new notifications
                    <a href="#"><span class="badge rounded-pill redBtn p-2 ms-2">View all</span></a>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
      
                  <li class="notification-item">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div>
                      <h6>Lorem Ipsum</h6>
                      <p>Quae dolorem earum veritatis oditseno</p>
                      <p>30 min. ago</p>
                    </div>
                  </li>
      
                  <li>
                    <hr class="dropdown-divider">
                  </li>
      
                  <li class="notification-item">
                    <i class="bi bi-x-circle text-danger"></i>
                    <div>
                      <h6>Atque rerum nesciunt</h6>
                      <p>Quae dolorem earum veritatis oditseno</p>
                      <p>1 hr. ago</p>
                    </div>
                  </li>
      
                  <li>
                    <hr class="dropdown-divider">
                  </li>
      
                  <li class="notification-item">
                    <i class="bi bi-check-circle text-success"></i>
                    <div>
                      <h6>Sit rerum fuga</h6>
                      <p>Quae dolorem earum veritatis oditseno</p>
                      <p>2 hrs. ago</p>
                    </div>
                  </li>
      
                  <li>
                    <hr class="dropdown-divider">
                  </li>
      
                  <li class="notification-item">
                    <i class="bi bi-info-circle text-primary"></i>
                    <div>
                      <h6>Dicta reprehenderit</h6>
                      <p>Quae dolorem earum veritatis oditseno</p>
                      <p>4 hrs. ago</p>
                    </div>
                  </li>
      
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li class="dropdown-footer">
                    <a class="redLink" href="#">Show all notifications</a>
                  </li>
      
                </ul><!-- End Notification Dropdown Items -->
      
              </li><!-- End Notification Nav -->
         </div>
     
        {{-- @endif --}}
        {{-- @if (Auth::check() && Auth::user()->role == 'user') --}}
            <div class="col-2 col-sm-2 d-flex justify-content-center a-no-underline">
                <a href="{{ route('issue-user-index') }}" class="material-symbols-outlined blackIcon icons m-1 align-middle">construction</a>
            </div>
        {{-- @endif --}}
     
    </div>
</div>
 