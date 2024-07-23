@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    @include('gym.user-checkIn')
    {{-- search box --}}
    @livewire('equipment-search',['isCheckIn' => $isCheckIn, 'category' => ''])
    @if ($maintenanceEquipment && $maintenanceEquipment->count() > 0)
    <div class="page-title">Equipment Under Maintenance <span class="text-danger">(DO NOT USE)</span></div>
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
    <div class="page-title">Available Equipment</div>
    @forelse($availableEquipment as $equipment)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment->image) }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$equipment->name}}</p>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                        Available: {{$equipment->available_machines_count}}
                    </div><br>
                    <a href="{{route('equipment-view',$equipment->equipment_id)}}" class="stretched-link"></a>
                    @if($isCheckIn)

                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-bs-toggle="modal" data-id="{{$equipment->equipment_id}}" data-bs-target="#viewEquipmentHabit">
                            Use
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    No available equipment
    @endforelse
    <div class="page-title mt-4">Categories</div>
        <div class=" row row-cols-2 row-cols-md-2 g-1">
            <div class="col no-padding ">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/treadmill.jpg') }}" class="categoryCardImg w-100 card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap w-80">Cardio Machines</span>
                    <a href="{{route('equipment-category','cardio machines')}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/dumbbell.jpg') }}" class="categoryCardImg w-100 card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap ">Free Weights</span>
                    <a href="{{route('equipment-category','free weights')}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/legpress.jpg') }}" class="categoryCardImg w-100 card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Leg Machines</span>
                    <a href="{{route('equipment-category','leg machines')}}" class="stretched-link"></a>
                </div>
            </div>
            <div class="col no-padding">
                <div class="category card border-0 shadow-none m-2">
                    <img src="{{ asset('/img/backmachine.jpg') }}" class="categoryCardImg w-100 card-img-overlay" alt="...">
                    <span class="card-title categoryCardTxt p-2 no-wrap">Upper Body Machines</span>
                    <a href="{{route('equipment-category','upper body machines')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
</div>
@include('partials.equipment.equipment-habit-modal')

@endsection
@push('script')
<script>
// document.addEventListener('DOMContentLoaded', function() {
//     document.getElementById('checkInBtn').addEventListener('click', function(event) {
//         console.log("HI");
//         fetch('{{ route("enter-gym") }}', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             }
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.gymsuccess) {
//                 console.log("S");
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Success',
//                     text: data.message,
//                     customClass: {
//                         confirmButton: 'btn redBtn'
//                     }
//                 });
//             } else {
//                 console.log("Y");

//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Error',
//                     text: data.message,
//                     customClass: {
//                         confirmButton: 'btn redBtn'
//                     }
//                 });
//             }
//         })
//         .catch(error => console.error('Error:', error));
//     });
// });

$(document).ready(function () {
    console.log("S");

    $('#checkOutBtn').on('click', function(e){
        console.log("S");
        e.preventDefault();
        swal.fire({
            title: 'Are you sure you want to check out?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn redBtn',
                cancelButton: 'btn blueBtn'
            },
            confirmButtonText: 'Yes, check out!'
        }).then((result) => {
            if (result.isConfirmed) {
                const checkOutForm = document.getElementById('checkOutForm');
                    if (checkOutForm) {
                        checkOutForm.submit();
                    } else {
                        console.error('CheckOutForm not found');
                    }
            }
        });
    });

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
                        var form = $('#habitModal');
                        var formAction = equipment.workout_habit_id
                    ? '{{ route("workout-habit-update", ":id") }}'.replace(':id', equipment.workout_habit_id)
                    : '{{ route("workout-habit-store") }}';
                        var method = equipment.workout_habit_id ? 'PUT' : 'POST';
                        form.attr('action', formAction); 
                        $('#formMethod').val(method); 
                    
                        displayDetails(equipment, modal);
                        modal.modal('show'); // Ensure the modal is shown after data is set
                        modal.find('.loading').html(''); // Clear loading message or replace with actual content

                    }, 200); 

                }
            },
        });
    });

    function displayDetails(equipment, modal) {
        modal.find('#reps').val("");
        modal.find('#sets').val("");
        modal.find('#weights').val("");
        modal.find('#allowSharing').val("");
        modal.find('#equipment_id').val("");
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
    }
});
</script>
@endpush