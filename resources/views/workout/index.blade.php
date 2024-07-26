@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    @if(!$workout && !$reservedEquipments && !$queuedEquipments)
        <div class="row mt-3">
            <div class="page-title" style="padding-right: 0px;">You are currently not using or queueing for any equipments </div>
            <br>
            <a href="{{route('equipment-index')}}" class="btn redLink">Browse equipments to use</a>
        </div>
    @endif
    @if($workout)
        <div id="ongoingWorkout">
            <div class="row mt-3">
                <div class="page-title" style="padding-right: 0px;">You are currently using</div>
            </div>
    
            <div class="card workout-card"  style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-5">
                            <h4>{{$workout->equipmentMachine->equipment->name}} </h4>
                        </div>
    
                        <div class="col-7 sharing">
                            <div class="circle grey"></div>
                            <div class="circle red"></div>
                        </div>
                    </div>
                    <div class="mb-4 timer d-flex justify-content-center align-items-center flex-column">
                        <h1 id="timer">00:00:00</h1>
                        <p id="workoutStatus"></p>
                        @if($workout->equipmentMachine->equipment->has_weight)
                        <h2 id="setNo" ></h2>
                        @endif
                    </div>
    
                    <div class="my-4 d-flex justify-content-center align-items-center text-center" style="gap: 15px;">
                        <div>
                            <button id="pause" class="btn btn-circle btn-green">
                                <span class="material-symbols-outlined" id="pauseIcon">
                                    play_arrow
                                    </span>                    
                                </button>
                            <br><span id="pauseText">Start</span>
                        </div>
                            
                        <div>
                            <button id="holdToEnd" class="btn btn-circle btn-red">
                                <span class="material-symbols-outlined">
                                    stop
                                </span>
                            </button>
                            <br>Hold to end
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('workout.workoutModal')

    @endif
    @if($reservedEquipments)
    {{-- <form action="{{route('workout-start',$reservedEquipments->workout_queue_id)}}" method="POST">
        @csrf
        <button type="submit">s</button>
    </form> --}}
    <div class="turnEquipment mb-4">
        <div class="row mt-3">
            <div class="page-title" style="padding-right: 0px;color:">It's your turn!</div>
        </div>
        <div class="card equipment shadow-sm mt-2 p-2" >
            <div class="row">
                <div class="col-5 ">
                        <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/backmachine.jpg') }}" alt="Work Order Image" ><br/>
                </div>
                <div class="col-7" style="padding-left: 5px">
                    <div class=" mt-md-3 no-wrap">
                        <p class="equipmentTitle">{{$reservedEquipments->equipment->name}} &nbsp;<span class="text-danger ">{{$reservedEquipments->equipmentMachine->label}}</span></p>
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                            Reserved for you
                        </div><br>
                        <a href="{{route('equipment-view',$reservedEquipments->equipment->equipment_id)}}" class="stretched-link"></a>
                        <div class="d-flex justify-content-end">
                            <button type="button" class=" start myBtn btnFront btn btn-primary redBtn shadow-none" data-id="{{$reservedEquipments->workout_queue_id}}">
                                Start
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p style="color: #C12323; font-weight: bold;">* Hurry up ! This equipment is reserved for you for only 2 minutes.</p>

    </div>
    @endif

    @if($queuedEquipments)
    <div class="row mt-3">
        <div class="page-title" style="padding-right: 0px;">Queued Equipment</div>
    </div>
    @endif
    @forelse($queuedEquipments as $equipment)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment->equipment->image) }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$equipment->equipment->name}}</p>
                    @php
                        $color = $equipment->status == 'Available'? 'success' : 'danger';
                    @endphp
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        {{$equipment->status}}
                    </div><br>
                    @if($equipment->status == 'Available' && !$workout)
                    <div class="d-flex justify-content-end">
                        <button type="button" class="start myBtn btnFront btn btn-primary redBtn shadow-none" data-id={{$equipment->workout_queue_id}}>
                            Start
                        </button>
                    </div>
                    @endif
                    <a href="{{route('equipment-view',$equipment->equipment->equipment_id)}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse
</div>
<div class="d-flex justify-content-center mt-5">
    <a href="{{route('workout-habit')}}" class="p-2 redBtn btn">
        Manage Workout Habit
    </a>
</div>

@endsection

@section('javascript')
<script src="{{ asset('js/timer.js') }}"></script>

@stop
@push('script')
<script>

    window.workoutStartRoute = '{{ route("workout-start") }}'; // Pass the route URL to a global JavaScript variable
    window.workoutIndex = '{{ route("workout-index") }}'; // Pass the route URL to a global JavaScript variable

@if(session('workoutsuccess'))
    Swal.fire({
        title: "Workout Completed!",
        text: "You are stronger than you think.",
        imageUrl: '/img/tada.png',
        imageWidth: 60,
        imageHeight: 60,
        imageAlt: "Tada"
    });
@endif
</script>
@endpush



