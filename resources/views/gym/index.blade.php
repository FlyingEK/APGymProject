@extends('layouts.trainerLayout')
@section('content')
<div class="content container p-1">
    <div class="gymCheckIn">
        <div class="page-title">Gym status: <span class="text-success">Not full</span></div>
        <div class="card workout-card mb-4" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
            <div class="card-body">
                {{-- <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">The gym is currently full. Please queue to enter the gym.</div>
                <div style="font-size:15px;font-weight:bold;" >Current queue: 3 people</div> --}}
                <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Current gym user: 10</div>
            </div>
            <div class="m-3 d-flex justify-content-end" style="gap:8px;">
                {{-- if got queue --}}
                <button type="button" data-bs-toggle="modal" data-bs-target="#checkInModal" class="btn redBtn">
                    User Check In
                </button>
                <a class="btn " style="background-color: #68b1de; color:white" href={{route('gym-user')}}>
                    View Gym User
                </a>
            </div>
        </div>
    </div>
    @livewire('equipment-search',['isCheckIn' => false, 'category' => ''])

    <div class="page-title">Equipment that are used longer</div>

@for($i=0;$i<3;$i++)
<div class="card equipment shadow-sm mt-2 p-2">
    <div class="row">
        <div class="col-5 ">
                <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 no-wrap">
                <p class="equipmentTitle">Equipment name  &nbsp;<span class="text-danger ">#TR0{{$i}}</span></p>
                <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                    <i class="fa-solid fa-helmet-safety"></i> 30 minutes
                </div><br>
                <a href="{{route('equipment-view',1)}}" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
@endfor
    <div class="page-title mt-4">Categories</div>
        <div class=" row row-cols-2 row-cols-md-2 g-1">
            <div class="col no-padding ">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/treadmill.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Cardio Machines</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/dumbbell.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Free Weights</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/legpress.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Leg Machines</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/backmachine.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Upper Body Machines</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>
</div>
@include('gym.checkin')
@endsection