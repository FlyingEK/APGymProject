@extends('layouts.userLayout')
@section('content')
<div class="profileCard card p-3">
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <img src="{{ $user->profile_image_url }}" alt="Profile Image" class="rounded-circle" style="width:80px;height:80px;">
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
<div class="pagetitle">Badges</div>

@endsection
