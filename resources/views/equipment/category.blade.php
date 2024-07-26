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
                  
                    @if($item->status == 'Available')
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        Available: {{ $item->available_machines_count }}
                        </div><br>
                    @else
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                            {{$item->status}}
                        </div><br>
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                            {{$item->statusDetail['currentPersonInQueue']}} in queue
                        </div>
                        <div class = "myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                            Estimated wait time: {{$item->statusDetail['totalEstimatedTime']}} mins
                        </div>
                    @endif
                    <a href="{{route('equipment-view', $item->equipment_id)}}" class="stretched-link"></a>
                    @if($isCheckIn)
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-id="{{$item->equipment_id}}" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
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
@push('script')
<script>
$('#viewEquipmentHabit').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var equipment_id = button.data('id');
    $('#viewEquipmentHabit .loading').html('<strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>');


    $.ajax({
        url: '{{ route("workout-habit-details") }}',
        type: 'GET',
        data: { id: equipment_id },
        success: function (response) {
            if (response.success){
                var equipment = response.equipment;
                console.log(equipment);
                const modal = $('#viewEquipmentHabit');
                // Use a slight delay to ensure data is fully populated before showing the modal
                setTimeout(function() {
                    displayDetails(equipment, modal);
                    modal.modal('show'); // Ensure the modal is shown after data is set
                    modal.find('.loading').html(''); // Clear loading message or replace with actual content

                }, 200); 
            }else{
                modal.find('.loading').html(''); // Clear loading message or replace with actual content
            }
        },
    });

    function displayDetails(equipment, modal) {
        modal.find('#reps').val("");
        modal.find('#sets').val("");
        modal.find('#weights').val("");
        modal.find('#allowSharing').val("");
        modal.find('#equipment_id').val("");
        modal.find('#workout_habit_id').val("");
        modal.find('#has_weight').val("");
        modal.find(".hasWeightInput").addClass('d-none');
        modal.find(".noWeightInput").addClass('d-none');
        if(equipment.has_weight == 1){
            modal.find(".hasWeightInput").removeClass('d-none');
            if(equipment.set){
                modal.find('#reps').val(equipment.repetition);
                modal.find('#sets').val(equipment.set);
                modal.find('#weights').val(equipment.weight);
                modal.find('#allowSharing').val(equipment.allowSharing);
            }
        }
        else{
            modal.find(".noWeightInput").removeClass('d-none');
            if(equipment.duration){
                modal.find('#duration').val(equipment.duration);
            }
        }
        modal.find('#equipment_id').val(equipment.equipment_id );
        modal.find('#has_weight').val(equipment.has_weight);
        modal.find('#workout_habit_id').val(equipment.workout_habit_id);

    }
});
</script>
@endpush