@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="d-none" id="ongoingWorkout">
        <div class="row mt-3">
            <div class="page-title" style="padding-right: 0px;">You are currently using</div>
        </div>

        <div class="card workout-card"  style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-5">
                        <h2>Treadmill</h2>
                    </div>

                    <div class="col-7 sharing">
                        <div class="circle grey"></div>
                        <div class="circle red"></div>
                    </div>
                </div>
                <div class="mb-4 timer d-flex justify-content-center align-items-center flex-column">
                    <h1 id="timer">00:00:00</h1>
                    <p id="workoutStatus"></p>
                    <h2 id="setNo"></h2>
                </div>

                <div class="my-4 d-flex justify-content-center align-items-center text-center" style="gap: 15px;">
                    <div>
                        <button id="pause" class="btn btn-circle btn-green">
                            <span class="material-symbols-outlined" id="pauseIcon">
                                pause
                                </span>                    
                            </button>
                        <br><span id="pauseText">Rest</span>
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
    <div class="turnEquipment mb-4">
        <div class="row mt-3">
            <div class="page-title" style="padding-right: 0px;color:">It's your turn!</div>
        </div>
        <div class="card equipment shadow-sm mt-2 p-2" >
            <div class="row">
                <div class="col-5 ">
                        <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
                </div>
                <div class="col-7" style="padding-left: 5px">
                    <div class=" mt-md-3 no-wrap">
                        <p class="equipmentTitle">Threadmill &nbsp;<span class="text-danger ">#TR01</span></p>
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                            <i class="fa-solid fa-helmet-safety"></i> Available
                        </div><br>
                        <a href="{{route('equipment-view')}}" class="stretched-link"></a>
                        <div class="d-flex justify-content-end">
                            <button type="button" class=" start myBtn btnFront btn btn-primary redBtn shadow-none">
                                Start
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p style="color: #C12323; font-weight: bold;">* Hurry up ! This equipment is reserved for you for only 2 minutes.</p>

    </div>
    {{-- if got quueued --}}
    <div class="row mt-3">
        <div class="page-title" style="padding-right: 0px;">Queued Equipment</div>
    </div>
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">Threadmill</p>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                        <i class="fa-solid fa-helmet-safety"></i> In use
                    </div><br>
                    <a href="{{route('equipment-view')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-5">
    <a href="" class="p-2 redBtn btn">
        Manage Workout Habit
    </a>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/timer.js') }}"></script>
@stop



