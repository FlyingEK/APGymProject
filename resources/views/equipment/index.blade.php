@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="gymCheckIn">
        <div class="page-title">Check In to Gym</div>
        <div class="card workout-card mb-4" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
            <div class="card-body">
                {{-- <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">The gym is currently full. Please queue to enter the gym.</div>
                <div style="font-size:15px;font-weight:bold;" >Current queue: 3 people</div> --}}
                <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Check in to the gym.</div>
            </div>
            <div class="m-3 d-flex justify-content-end">
                {{-- if got queue --}}
                {{-- <button type="button" class="myBtn btn btn-primary redBtn shadow-none">
                    Queue
                </button> --}}
                <button type="button" class="myBtn btn btn-primary redBtn shadow-none" onclick="$('.gymCheckIn').addClass('d-none')">
                    Check In
                </button>
            </div>
        </div>
    </div>
    <div class="input-group mt-2 searchBox mb-2">
        <input type="search" class="form-control rounded border-0" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
      </div>
    <div class="page-title">Available Equipment</div>
    @for($i=0;$i<3;$i++)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">Equipment name</p>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                        <i class="fa-solid fa-helmet-safety"></i> Available
                    </div><br>
                    <a href="{{route('equipment-view')}}" class="stretched-link"></a>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                            Use
                        </button>
                    </div>
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
@include('partials.equipment.equipment-habit-modal')

@endsection