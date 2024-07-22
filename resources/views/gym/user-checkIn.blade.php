<div class="gymCheckIn">
    <div class="page-title">{{$isCheckIn?"Check Out":"Check In to Gym"}}</div>
    <div class="card workout-card mb-4" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
        <div class="card-body">
            @if ($gymIsFull)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">The gym is currently full. Please queue to enter the gym.</div>
            <div style="font-size:15px;font-weight:bold;" >Current queue: {{ $currentQueueCount }} people</div>
            @elseif(!$gymIsFull)
                <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Check in to the gym.</div>
            @endif
        </div>
        <div class="m-3 d-flex justify-content-end">
            <button type="button" class="myBtn btn btn-primary redBtn shadow-none" id="checkInBtn">
                {{$gymIsFull?"Queue":"Check In"}} 
            </button>
            @if ($isCheckIn)
            <button type="button" class="myBtn btn btn-primary redBtn shadow-none" id="checkOutBtn">
                    Check Out
            </button>
            @endif
        </div>
    </div>
</div>
