<div class="gymCheckIn">
    <div class="page-title">{{$isCheckIn?"Check Out":"Check In to Gym"}}</div>
    <div class="card workout-card mb-4" style="background: url('{{ asset('/img/workoutbg.jpg') }}') ">
        <div class="card-body">
            @if ($isCheckIn)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Checkout from the gym.</div>
            @elseif($isQueue)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">You are currently in the queue. Please wait for your turn.</div>
            <div style="font-size:15px;font-weight:bold;" >Current queue: {{ $currentQueueCount }} people</div>
            @elseif($isReserved)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Please enter your check in verification code on the trainer device.</div>
            @elseif ($gymIsFull)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">The gym is currently full. Please queue to enter the gym.</div>
            <div style="font-size:15px;font-weight:bold;" >Current queue: {{ $currentQueueCount }} people</div>
            @elseif(!$gymIsFull)
            <div style="font-size:22px;font-weight:bold;" text-wrap="wrap">Gym status: Not full</div>
                <div style="font-size:15px;font-weight:bold;" text-wrap="wrap">Check in to the gym to access to the equipment.</div>
            @endif
        </div>
        <div class="m-3 d-flex justify-content-end">
            @if($isQueue)
            <form action={{ route("exit-queue") }} method="POST" id="exitQueue">
                @csrf
                <button type="submit" class="myBtn btn btn-primary redBtn shadow-none" id="checkInBtn">
                    Exit Queue
                </button>
            </form>
            @elseif (!$isCheckIn && !$isQueue && !$isReserved)
            <form action={{ route("enter-gym") }} method="POST" id="checkInForm">
                @csrf
                <button type="submit" class="myBtn btn btn-primary redBtn shadow-none" id="checkInBtn">
                    {{$gymIsFull?"Queue":"Check In"}} 
                </button>
            </form>
            @elseif($isCheckIn)
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
<script>
$('#exitQueue').submit(function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be removed from the queue.",
        icon: 'warning',
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn redBtn',
            cancelButton: 'btn blueBtn'
        },
        confirmButtonText: 'Yes, remove me!'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
}); 
</script>
