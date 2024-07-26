@extends('layouts.userLayout')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
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
            </div>
        </div>
    </div>

    
@endsection
@section('javascript')
    <script src="{{ asset('/js/img-preview.js') }}"></script>
@endsection