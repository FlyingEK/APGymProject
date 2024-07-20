@extends('layouts.userLayout')
@section('content')
<div class="auth-container mt-5 d-flex flex-column align-items-center mt-5">
    <div class="card p-4" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <h3><b>Reset your password</b></h3>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
                        <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
    
            <!-- Email Address -->
            <div class="m-3">
                <input type="email" class="form-control" placeholder="Email" name="email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Password -->
            <div class="m-3">
                <input type="password" class="form-control" placeholder="Password" name="password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Confirm Password -->
            <div class="m-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
                @error('confirm_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="d-flex align-items-center justify-content-center mt-4">
                <button class="redBtn btn" type="submit">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

