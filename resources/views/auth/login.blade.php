@extends('layouts.userLayout')
@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-container d-flex flex-column align-items-center">
        <img src={{asset('/img/apulogo.png')}} alt="APGYM Logo">
        <div class="logo m-1">
            <span  style = "color:#C12323;">AP</span><span   style = "color:#192126;">GYM</span>
        </div>
        <h1><b>Sign In</b></h1>
        <p class="text-muted mb-2">Sweat now, shine later.</p>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control"  placeholder="Password"  name="password" >
            </div>
            <div class="d-flex justify-content-end mb-3">
                <a class="text-muted " href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            <button type="submit" class="btn redBtn btn-block w-100">LOGIN</button>
        </form>
        <p class="text-muted mt-3">Don't have an account? <a class="redLink" href="{{ route('register') }}">Signup</a></p>
    </div>
    
    </body>
    </html>
@endsection
