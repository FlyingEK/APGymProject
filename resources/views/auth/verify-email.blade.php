@extends('layouts.userLayout')
@section('content')
<div class="auth-container mt-5 d-flex flex-column align-items-center mt-5">
    <div class="logo m-2">
        <span  style = "color:#C12323;">AP</span><span   style = "color:#192126;">GYM</span>
    </div>
    <div class="card p-4" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <h2 class="mb-4">
            <b>Thanks for signing up!</b>
        </h2>
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{__('Please verify your email address by clicking on the link we just emailed to you.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-3 d-flex align-items-center justify-content-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <button class="redBtn btn" style="font-size: 14px;">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="blueBtn btn" style="font-size: 14px;">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
