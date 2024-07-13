@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="">
        <div class="pgtabs pgtab1 btn-group btn-group-md">
            <a href="#" class="btn   " aria-current="page">Goals</a>
            <a href="#" class="btn   active">Reports</a>
            <a href="#" class="btn  ">Leaderboard</a>
        </div>
    </div>

    <div class=" mt-3">
        <div class="pgtabs pgtab2 btn-group btn-group-sm" id="report-tab">
            <a href="#" class="btn " aria-current="page">Daily</a>
            <a href="#" class="btn active">Monthly</a>
            <a href="#" class="btn  ">Annually</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <div class="page-title" style="padding-right: 0px;">Workout Report</div>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <div class="report-filter">
                <a href="#">
                    <i class="material-symbols-outlined redIcon no-wrap">tune</i><span>  This Month</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class = "row align-items-center">
                <div class = "col-7 custom-padding">
                    <p class="report-label card-text">Days of working out:</p>
                </div>
                <div class = "col-5 no-padding">
                    <p class=" report-value card-text">15 days</p>
                </div>
            </div>
            <div class = "row align-items-center">
                <div class = "col-7 custom-padding">
                    <p class="report-label card-text">Total Workout Time:</p>
                </div>
                <div class = "col-5 no-padding">
                    <p class= "report-value card-text">35 hours</p>
                </div>
            </div>
            <div class = "row align-items-center" style="margin: 12px -15px;">
                <div class = "col-12 custom-padding">
                    <p class="report-label card-text">Most used equipment:</p>
                </div>
            </div>
            <div class=" row row-cols-3 row-cols-md-3 g-1">
                <div class="col">
                    <div class="equipmentCard card border-0 shadow-none">
                        <img src="{{ asset('/img/treadmill.jpg') }}"  class="equipmentCardImg card-img-top" alt="...">
                        <span class="card-text equipmentCardTxt text-center">10 hours</span>
                    </div>
                </div>
                <div class="col">
                    <div class="equipmentCard card border-0 shadow-none">
                        <img src="{{ asset('/img/treadmill.jpg') }}"  class="equipmentCardImg card-img-top" alt="...">
                        <span class="card-text equipmentCardTxt text-center">10 hours</span>
                    </div>
                </div>
                <div class="col">
                    <div class="equipmentCard card border-0 shadow-none">
                        <img src="{{ asset('/img/treadmill.jpg') }}"  class="equipmentCardImg card-img-top" alt="...">
                        <span class="card-text equipmentCardTxt text-center">10 hours</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div>
        <div class="row mt-4">
            <div class="col-6 ">
                <div class="page-title" style="padding-right: 0px;">Workout History</div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div class="report-filter">
                    <a href="#">
                        <i class="material-symbols-outlined redIcon no-wrap">tune</i><span>  Today</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="workoutSection mt-2">
            <div class="workoutHistoryDate">06 June 2024</div>
            <table class="table workoutHistoryTable">
                @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="w-60">Equipment</td>
                        <td class="w-30" >Duration</td>
                        <td class="w-5 text-right"><span class="material-symbols-outlined">chevron_right</span></td>
                    </tr>
                
                @endfor
            </table>
        </div>
    </div>
</div>
@include('partials.workout-analytic.leaderboard')

@endsection

@section('javascript')
    <script src="{{ asset('/js/set-active-class.js') }}"></script>
    <script>
    window.addEventListener('load', function() {
        const container = document.querySelector('.leaderboard-container');
        const highlightedPlayer = document.querySelector('.highlighted-player');
    
        function setHighlightedPlayerWidth() {
            const containerWidth = container.offsetWidth;
            highlightedPlayer.style.width = `${containerWidth}px`;
        }
    
        setHighlightedPlayerWidth();
        window.addEventListener('resize', setHighlightedPlayerWidth);
    });
    </script>
@stop



