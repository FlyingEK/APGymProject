<div class="container">
  <div class="header row"> 
      <div class="col-8 col-sm-8">
          <div class="logo m-1">
              <span style="color:#C12323;">AP</span><span style="color:#192126;">GYM</span>
          </div>
      </div>
       <!-- Display different partials based on user role -->
       @if (Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'trainer'))
       <div class="col-2 col-sm-2 d-flex justify-content-center a-no-underline">
          <li class="nav-item dropdown">
              <a class="nav-link nav-icon d-inline" href="#" id="notificationsDropdown" data-bs-toggle="dropdown">
                  <span class="material-symbols-outlined blackIcon icons m-1 align-middle">notifications</span>
                  @if(Auth::user()->unreadNotifications->count()> 0)
                  <span class="pulse"></span>
                  @endif
              </a><!-- End Notification Icon -->
    
              <ul class="p-3 dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                <li class="dropdown-header">
                  You have {{ Auth::user()->unreadNotifications->count() }} new notifications
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <div id="notificationsList">
                @forelse (Auth::user()->unreadNotifications as $notification)
                <li class="notification-item">
                  <i class="bi bi-exclamation-circle text-warning"></i>
                  <div>
                    <h6></strong>{{ $notification->data['title'] }}</strong></h6>
                    <p>{{ $notification->data['message'] }}</p>
                    <p style="font-size: 12.5px;">{{ $notification->data['datetime'] }}</p>
                  </div>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                @empty
                @endforelse
                </div>
                
                <li class="dropdown-footer">
                  <a class="redLink" href="{{route('notification-index')}}">Show all notifications</a>
                </li>
              </ul><!-- End Notification Dropdown Items -->
            </li><!-- End Notification Nav -->
       </div>
      @endif
      <div class="col-2 col-sm-2 d-flex justify-content-center a-no-underline">
          <a href="{{ route('issue-user-index') }}" class="material-symbols-outlined blackIcon icons m-1 align-middle">construction</a>
      </div>
  </div>
</div>
