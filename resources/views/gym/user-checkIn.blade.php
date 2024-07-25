<div class="gymCheckIn">
    <div class="page-title">{{$isCheckIn?"Check Out":"Check In to Gym"}}</div>
    <div class="card workout-card mb-4" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
        <div class="card-body">
            @if ($isCheckIn)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Checkout from the gym.</div>
            @elseif($isQueue && $gymIsFull)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">You are currently in the queue. Please wait for your turn.</div>
            <div style="font-size:15px;font-weight:bold;" >Current queue: {{ $currentQueueCount }} people</div>
            @elseif($isQueue && !$gymIsFull)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Please enter your check in verification code on the trainer device.</div>
            @elseif ($gymIsFull)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">The gym is currently full. Please queue to enter the gym.</div>
            <div style="font-size:15px;font-weight:bold;" >Current queue: {{ $currentQueueCount }} people</div>
            @elseif(!$gymIsFull)
                <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Check in to the gym.</div>
            
            @endif
        </div>
        <div class="m-3 d-flex justify-content-end">
            @if (!$isCheckIn && !$isQueue)
            <form action={{ route("enter-gym") }} method="POST" id="checkInForm">
                @csrf
                <button type="submit" class="myBtn btn btn-primary redBtn shadow-none" id="checkInBtn">
                    {{$gymIsFull?"Queue":"Check In"}} 
                </button>
            </form>
            @else
            <form  action={{ route("leave-gym") }} method="POST" id="checkOutForm">
                @csrf
                <button type="button" class="myBtn btn btn-primary redBtn shadow-none" id="checkOutBtn">
                        Check Out
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
