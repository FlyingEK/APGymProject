@extends('layouts.adminLayout')
@section('content')
<div class="pagetitle">
    <h1>Equipment</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Equipment</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="tableContainer">
    <div class="row">
        <div class="col-lg-12 col-sm-12 d-flex">
            <div class="pagetitle align-content-center justify-content-center me-4">
                <h1>All Equipments</h1>
            </div>
            <a href="{{ route('equipment-add') }}" class="btn rounded-pill ms-2 submit-button ps-3 pe-3 pt-2 pb-2">
                <i class="fa fa-plus me-2"></i>
                Add Equipment
            </a>
        </div>
        <!-- Table with stripped rows -->

        <table class="table datatable borderless w-100" id="allEquipmentTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Equipment Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipment as $index => $equip)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $equip->name }}</td>
                        <td>{{ $equip->description??"N/A" }}</td>
                        <td>{{ $equip->category}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('equipment-admin-view', $equip->equipment_id) }}"><span class="material-symbols-outlined">visibility</span> &nbsp View</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('equipment-edit', $equip->equipment_id) }}"><span class="material-symbols-outlined">edit</span>&nbsp Edit</a></li>
                                    <li>
                                        {{-- quantity 0 --}}
                                        <button type="button" onclick="deleteEquipment('{{$equip->equipment_id}}')" class="dropdown-item d-flex align-items-center">
                                            <span class="material-symbols-outlined">delete</span> &nbsp Delete
                                        </button>

                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</section>

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
                                location.reload();
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
