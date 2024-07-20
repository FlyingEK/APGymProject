
@extends('layouts.userLayout')
@section('content')
<div class="auth-container mt-5 d-flex flex-column align-items-center mt-5">
    <div class="card p-4" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            <h3><b>Forgot your password?</b></h3>
            We will email you a password reset link that will allow you to choose a new one.
        </div>
         <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
                <!-- Email Address -->
        <div>
            <input class="form-control" name="email" type="email" placeholder="Email" :value="old('email')">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-center mt-4">
            <button class="redBtn btn" type="submit">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
    </div>
</div>
@endsection

