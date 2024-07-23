@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    @livewire('equipment-search',['isCheckIn' => $isCheckIn, 'category' => $category])

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
                        @if($equipment->status == 'Available')
                        Available: {{ $equipment->available_machines_count }}
                        @else
                            {{$equipment->status}}
                        @endif
                    </div><br>
                    <a href="{{route('equipment-view', $item->equipment_id)}}" class="stretched-link"></a>
                    @if($isCheckIn)
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                            {{$item->status == 'Available'? 'Use' : 'Queue'}}
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