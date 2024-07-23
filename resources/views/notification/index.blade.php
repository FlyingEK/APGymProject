@extends('layouts.userLayout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="page-title p-3">Notifications</div>

                <div class="card-body">
                    @forelse (Auth::user()->unreadNotifications as $notification)
                    <li class="notification-item">
                      <i class="bi bi-exclamation-circle text-warning"></i>
                      <div>
                        <h6><strong>{{ $notification->data['title'] }}</strong></h6>
                        <p>{{ $notification->data['message'] }}</p>
                        <p style="font-size: 12.5px;">{{ $notification->data['datetime'] }}</p>
                      </div>
                    </li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    @empty
                    @endforelse
                    @forelse (Auth::user()->readNotifications as $notification)
                    <li class="notification-item">
                      <i class="bi bi-exclamation-circle text-warning"></i>
                      <div>
                        <h6><strong>{{ $notification->data['title'] }}</strong></h6>
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
            </div>
        </div>
    </div>
</div>
@endsection
