@extends('layouts.userLayout')

@section('content')
<div class="auth-container mt-5 d-flex flex-column align-items-center">
    <div class="card p-4" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <h2 class="mb-4">
            <b>{{ __('Thanks for signing up!') }}</b>
        </h2>
        <div class="mb-4 text-sm text-secondary">
            {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-3 d-flex align-items-center justify-content-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn redBtn" style="font-size: 14px;">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary" style="font-size: 14px;">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
