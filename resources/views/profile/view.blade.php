@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">

<div class="profileCard card p-2">
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('/img/user.jpg') }}" alt="Profile Image" class="rounded-circle" style="width:80px;height:80px;">
            </div>
            <div class="col-8">
                <span class="pagetitle" style="font-weight:bold;">{{ $user->username }} &nbsp</span>
                @if($user->gender)
                    @if($user->gender == 'male')
                        <i class="fas fa-mars" style="color: rgb(66, 170, 223);"></i>
                    @elseif($user->gender == 'female')
                        <i class="fas fa-venus" style="color: rgb(245, 89, 89);" ></i>
                    @endif
                @endif
                <br>
                <a href="{{ route('profile.edit') }}" class="redLink">Edit Profile</a>
            </div>
        </div>

        <!-- Display badges here -->
    </div>
</div>
<div class="page-title mt-3">Achievement Badges</div>
<div class="card mb-5">
    <div class="badge">
        <div class="d-flex flex-row flex-wrap justify-content-center">
            @forelse($achievements as $achievement)
                <img src="{{ asset('storage/'.$achievement->achievement->image) }}" class="badgeImg" alt="Warrior Badge" data-toggle="tooltip" data-placement="bottom" title="{{ $achievement->achievement->condition }}">
            @empty
            @endforelse
            @forelse($lockAchievements as $achievement)
                <img src="{{ asset('storage/'.$achievement->image) }}" class="badgeImg fadeBadge" alt="Warrior Badge" data-toggle="tooltip" data-placement="bottom" title="{{ $achievement->condition }}">
            @empty
            @endforelse
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center align-items-center justify-content-center" style="flex-direction: row;gap:8px;"> 
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a class="redBtn btn"  onclick="event.preventDefault();
                            this.closest('form').submit();">
            <i class="fas fa-sign-out-alt"></i>   Logout
        </a>
    </form>
</div>
@endsection
