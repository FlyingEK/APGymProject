@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="gymCheckIn">
        <div class="page-title">
            Gym status: 
            {!! $gymIsFull 
                ? '<span class="text-danger">Full</span>' 
                : '<span class="text-success">Not full</span>' 
            !!}
        </div>
        <div class="card workout-card mb-4" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
            <div class="card-body">
                <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Current gym user: {{$currentUserCount}} people</div>
                @if($currentQueueCount > 0)
                <div style="font-size:15px;font-weight:bold;" >Current queue: {{$currentQueueCount}} people</div>
                @endif
            </div>
            <div class="m-3 d-flex justify-content-end" style="gap:8px;">
                <button type="button" data-bs-toggle="modal" data-bs-target="#checkInModal" class="btn redBtn">
                    User Check In
                </button>
                <a class="btn " style="background-color: #68b1de; color:white" href={{route('gym-user')}}>
                    View Gym User
                </a>
            </div>
        </div>
    </div>
    @livewire('search-equipment-machine',['category' => ''])

@if ($maintenanceEquipment && $maintenanceEquipment->count() > 0)
<div class="page-title">Equipment Under Maintenance</div>
@foreach($maintenanceEquipment as $equipment)
<div class="card equipment shadow-sm mt-2 mb-2 p-2">
    <div class="row">
        <div class="col-5 ">
                <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment->image) }}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 no-wrap">
                <p class="equipmentTitle">{{$equipment->name}} <span class="text-danger">#{{$equipment->equipmentMachines[0]->label}}</span></p>
                <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-warning shadow-none">
                        Maintenance
                </div><br>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

<div class="page-title">Equipment that are used longer</div>

@forelse($exceededEquipments as $equipment)
<div class="card equipment shadow-sm mt-2 p-2">
    <div class="row">
        <div class="col-5 ">
                <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment['equipment']->image)}}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 mb-3 no-wrap">
                <p class="equipmentTitle">{{$equipment['equipment']->name}}  &nbsp;<span class="text-danger ">#{{$equipment['equipmentMachine']->label}} </span></p>
                <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                    Exceeded {{$equipment['exceededTime']}} minutes
                </div><br>
            </div>
            {{-- @if( $equipment['equipmentMachine']->status == 'in use')
            <form id="updateStatus{{$equipment['equipmentMachine']->equipment_machine_id}}" action = {{route('equipment-status-update', $equipment['equipmentMachine']->equipment_machine_id)}} method="POST">
                @csrf
                <div class="d-flex justify-content-end">
                    <button type="button" onclick="confirmUpdateStatus('updateStatus{{$equipment['equipmentMachine']->equipment_machine_id}}')" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                        Update Status
                    </button>
                </div>
            </form>
            @endif --}}
        </div>
    </div>
</div>
@empty
    <p> No equipment is used longer than the limit.</p>
@endforelse
    <div class="page-title mt-4">Categories</div>
        <div class=" row row-cols-2 row-cols-md-2 g-1">
            <div class="col no-padding ">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/treadmill.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Cardio Machines</span>
                    <a href="{{route('equipment-trainer-category','cardio machines')}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/dumbbell.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Free Weights</span>
                    <a href="{{route('equipment-trainer-category','free weights')}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/legpress.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Leg Machines</span>
                    <a href="{{route('equipment-trainer-category','leg machines')}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/backmachine.jpg') }}" class="categoryCardImg card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Upper Body Machines</span>
                    <a href="{{route('equipment-trainer-category','upper body machines')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
</div>
@include('gym.checkin')
@endsection
@push('script')
<script>

function confirmUpdateStatus($formId){
    swal.fire({
        title: 'Are you sure?',
        text: "You are about to update the status of the equipment.",
        icon: 'warning',
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn redBtn',
            cancelButton: 'btn blueBtn'
        },
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById($formId).submit();
        }
    })
}


</script>
@endpush