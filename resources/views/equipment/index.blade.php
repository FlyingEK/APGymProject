@extends('layouts.layout')
@section('content')
<div class="content container p-1">
    <div class="">
</div>
    <div class="page-title">Available Equipment</div>
{{-- take from VS workorderinfo --}}

    <div>
    <div class="page-title">Categories</div>
        <div class=" row row-cols-2 row-cols-md-2 g-1">
            <div class="col no-padding ">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('img/threadmill.jpg') }} class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Cardio Machines</span>
                    <a href="#" class="btn btn-primary stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('img/threadmill.jpg') }} class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Free Weights</span>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('img/threadmill.jpg') }} class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Leg Machines</span>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('img/threadmill.jpg') }} class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Upper Body Machines</span>
                </div>
            </div>
        </div>
</div>
@endsection