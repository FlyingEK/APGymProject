@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="input-group searchBox mb-2">
        <input type="search" class="form-control rounded border-0" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
      </div>
    <div class="page-title">{{ucfirst($category)}}</div>
    @forelse($equipment as $item)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$item->name}}</p>
                    @php
                        $color = $item->status == 'Available'? 'success' : 'danger';
                    @endphp
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        {{$item->status}}
                    </div><br>
                    <a href="{{route('equipment-view', $item->equipment_id)}}" class="stretched-link"></a>
                    @if($isCheckIn)
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                            Use
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    No equipment
    @endforelse


</div>
@include('partials.equipment.equipment-habit-modal')

@endsection