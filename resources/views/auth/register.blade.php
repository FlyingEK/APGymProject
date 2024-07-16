@extends('layouts.userLayout')
@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="register-container d-flex flex-column align-items-center">
        <img src={{asset('/img/apulogo.png')}} alt="APGYM Logo">

        <div class="logo m-1">
            <span  style = "color:#C12323;">AP</span><span   style = "color:#192126;">GYM</span>
        </div>
        <h1><b>Register</b></h1>
        <form id="registerForm" action="{{ route('register-store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                @error('confirm_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn redBtn btn-block w-100 mt-3">REGISTER</button>
        </form>
        <a class="redLink mt-3" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
    </div>

@endsection
