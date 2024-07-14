@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="row mt-3">
        <div class="page-title" style="padding-right: 0px;">You are currently using</div>
    </div>

    <div class="card workout-card" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
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
                <h1>15:03:00</h1>
                <p>Working out/Resting</p>
                <h2>Set 2</h2>
            </div>

            <div class="my-4 d-flex justify-content-center align-items-center text-center" style="gap: 15px;">
                <div>
                    <button class="btn btn-circle btn-green">
                        <span class="material-symbols-outlined">
                            pause
                            </span>                    
                        </button>
                    <br>Rest
                </div>
                    
                <div>
                    <button class="btn btn-circle btn-red">
                        <span class="material-symbols-outlined">
                            stop
                            </span>
                    </button>
                    <br>Hold to end
                </div>
            </div>
        </div>
    </div>
    
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
                    <p class="equipmentTitle">Equipment name</p>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                        <i class="fa-solid fa-helmet-safety"></i> Available
                    </div><br>
                    <a href="{{route('equipment-view')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
@stop



