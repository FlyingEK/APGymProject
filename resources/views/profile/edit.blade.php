@extends('layouts.userLayout')
@section('content')
<div class="backLink  mb-2">
    <a href="{{route('profile.view')}}">
        <i class="fas fa-chevron-left"></i><span>  Back</span>
    </a>
</div>
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
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('/js/img-preview.js') }}"></script>
@endsection