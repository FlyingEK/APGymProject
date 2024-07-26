@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>View Constraint</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('constraint-all') }}">Gym Constraint</a></li>
            <li class="breadcrumb-item active">{{ $constraint->constraint_name}}</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="row ">
        <div class="pagetitle p-3">
            <h1>Constraint Details</h1>
        </div>
    </div>
    <div class="row m-3">
        <div class="col-lg-12">
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Constraint Name:</div>
                <div class="col-lg-9 col-md-8">{{ $constraint->constraint_name}}</div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Constraint Value:</div>
                <div class="col-lg-9 col-md-8">{{ $constraint->constraint_value}}</div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-12 d-flex justify-content-end gap-2">
                    <a href="{{route('constraint-edit', $constraint->constraint_id)}}" class="btn blueBtn">Edit</a>
                    <a onclick="deleteConstraint('{{$constraint->constraint_id}}')" class="btn redBtn">Delete Constraint</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
function deleteConstraint(id) {
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
                    url: '{{ route("constraint-delete") }}',
                    type: 'POST',
                    data: { 
                        _token: token, 
                        _method: 'DELETE',
                        id: id 
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Constraint has been deleted successfully',
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.href = '{{ route("constraint-all") }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete constraint',
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
                            text: 'Failed to delete constraint',
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



