@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <ul class="nav nav-tabs nav-tabs-bordered pgtabs pgtab1 mt-4 mb-3">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#goals">Goals</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reports">Reports</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#leaderboard">Leaderboard</button>
        </li>
    </ul>

    <div class="tab-content pt-2">
        <div class="tab-pane fade show active" id="goals">
            @include('partials.workout-analytic.goal')
        </div>
        <div class="tab-pane fade" id="reports">
            <!-- Reports content -->
            @include('partials.workout-analytic.report')
        </div>
        <div class="tab-pane fade" id="leaderboard">
            <!-- Leaderboard content -->
            @include('partials.workout-analytic.leaderboard')
        </div>
    </div><!-- End Additional Tabs -->
</div>



@endsection

@section('javascript')
    <script src="{{ asset('/js/set-progress.js') }}"></script>
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



