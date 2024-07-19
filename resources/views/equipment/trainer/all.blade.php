@extends('layouts.trainerLayout')
@section('content')
<div class="content container p-1">
    <div class="input-group searchBox mb-2">
        <input type="search" class="form-control rounded border-0" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
      </div>
    <div class="page-title">Available Equipment</div>
    @for($i=0;$i<5;$i++)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">Equipment name</p>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                        <i class="fa-solid fa-helmet-safety"></i> Available
                    </div><br>
                    <a href="{{route('equipment-view')}}" class="stretched-link"></a>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                            Update Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endfor
    @for($i=0;$i<5;$i++)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">Equipment name</p>
                    <div  class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none" >
                        In use
                    </div>
                    <div class="myBtn btn m-2 equipmentSmTag btn-sm btn-outline-dark shadow-none">
                        Queue: 1 person
                    </div>
                    <div class="myBtn btn m-2 equipmentSmTag btn-sm btn-outline-dark shadow-none">
                        Wait time: 20mins
                    </div>

                    <a href="{{route('equipment-view')}}" class="stretched-link"></a>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                            Update Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endfor
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
                    <img src="{{ asset('/img/treadmill.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Free Weights</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/treadmill.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Leg Machines</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/treadmill.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Upper Body Machines</span>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>
</div>
@include('partials.equipment.equipment-habit-modal')

@endsection