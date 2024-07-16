@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="input-group searchBox mb-2">
        <input type="search" class="form-control rounded border-0" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
      </div>
    <div class="page-title">Equipments</div>
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
                            <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                                Use
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor

</div>
@include('partials.equipment.equipment-habit-modal')

@endsection