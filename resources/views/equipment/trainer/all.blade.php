@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    @livewire('search-equipment-machine',['category' => ''])
    
    <div class="page-title mt-3">In Use Equipment</div>

    @forelse($inUseEquipments as $equipment)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment->equipment->image)}}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$equipment->equipment->name}}   <span class="redIcon">#{{$equipment->label}}</span></p>
                    <div  class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none" >
                        In use
                    </div>
                    @if( $equipment->status == 'in use')
                    <form id="updateStatus{{$equipment->equipment_machine_id}}" action = {{route('equipment-status-update', $equipment->equipment_machine_id)}} method="POST">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <button type="button" onclick="confirmUpdateStatus('updateStatus{{$equipment->equipment_machine_id}}')" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                                Update Status
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
        <p> No equipment is in use.</p>
    @endforelse
    <div class="page-title">Available Equipment</div>
    @forelse($availableEquipments as $equipment)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment->equipment->image)}}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$equipment->equipment->name}}   <span class="redIcon">#{{$equipment->label}}</span></p>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                        <i class="fas fa-helmet-safety"></i> Available
                    </div><br>
                </div>
            </div>
        </div>
    </div>
    @empty
        <p> No equipment is available.</p>
    @endforelse

</div>
@include('partials.equipment.equipment-habit-modal')

@endsection
<script>
    function confirmUpdateStatus($formId){
    swal.fire({
        title: 'Are you sure?',
        text: "You are about to update the status of the equipment.",
        icon: 'warning',
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn redBtn',
            cancelButton: 'btn blueBtn'
        },
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById($formId).submit();
        }
    })
}
</script>