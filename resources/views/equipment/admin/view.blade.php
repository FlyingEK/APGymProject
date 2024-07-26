@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>View Equipment</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('equipment-all') }}">Equipment</a></li>
            <li class="breadcrumb-item active">View Equipment</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;font-size:14px;">
    <div class="pagetitle p-3">
        <h1>Equipment Details</h1>
    </div>
    <div class="row m-3">
        <div class="col-lg-12">
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Equipment Name:</div>
                <div class="col-lg-9 col-md-8">{{ $equipment->name }}</div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Description:</div>
                <div class="col-lg-9 col-md-8">{{ $equipment->description ?? 'N/A'  }}</div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Category:</div>
                <div class="col-lg-9 col-md-8">{{ $equipment->category}}</div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Quantity:</div>
                <div class="col-lg-9 col-md-8">{{ $equipment->quantity }}</div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Equipment Machines:</div>
                <div class="col-lg-9 col-md-8"> 
                    @foreach ($equipment->equipmentMachines as $machine)
                    <span class="redLink">#{{ $machine->label }}</span>&nbsp;&nbsp;
                @endforeach
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Equipment Image:</div>
                <div class="col-lg-9 col-md-8">
                    <img src="{{ asset('storage/'.$equipment->image) }}" alt="Equipment Image" class="adminImg img-fluid">
                </div>
            </div>
        </div>
    </div>
    <div class="pagetitle p-3">
        <h1>Equipment Tutorial</h1>
    </div>
    <div class="row m-3">
        <div class="col-lg-12">
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Tutorial Instructions:</div>
                <div class="col-lg-9 col-md-8">
                    <ul>
                        @if ($equipment->tutorials->isEmpty())
                            <li>No tutorial available</li>
                        @endif
                        @foreach ($equipment->tutorials as $tutorial)
                            <li class="mb-3">{{ $loop->iteration }}. {{ $tutorial->instruction }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Tutorial Video:</div>
                <div class="col-lg-9 col-md-8">
                    @if($equipment->tutorial_youtube )
                        <iframe id="video-preview" width="380" height="260" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen src="{{ $equipment->tutorial_youtube }}"></iframe>
                    @else
                        <p>No tutorial video available</p>
                    @endif
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('equipment-edit', $equipment->equipment_id) }}" class="btn blueBtn">Edit</a>
                    <a onclick="deleteEquipment('{{$equipment->equipment_id}}')" class="btn redBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')
<script>
function deleteEquipment(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn redBtn',
            cancelButton: 'btn blueBtn'
        },
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(() => {
                token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route("equipment-delete") }}',
                    type: 'POST',
                    data: { 
                        _token: token, 
                        _method: 'PUT',
                        id: id 
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Equipment has been deleted successfully',
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.href = '{{ route("equipment-all") }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete equipment',
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete equipment',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }, 1000);
        }
    });
}

</script>
@endpush
