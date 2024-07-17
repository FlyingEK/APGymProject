@extends('layouts.adminLayout')
@section('content')
<div class="pagetitle">
    <h1>Gym Constraint</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Gym Constraint</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="tableContainer">
    <div class="row">
        <div class="col-lg-12 col-lg-12 col-sm-12 d-flex">
            <div class="pagetitle align-content-center justify-content-center me-4">
                <h1>All Gym Constraints</h1>
            </div>
            <a href="{{ route('constraint-create') }}" class="btn rounded-pill ms-2 submit-button ps-3 pe-3 pt-2 pb-2">
                <i class="fa fa-plus me-2"></i>
                Add Constraint
            </a>
        </div>
        <!-- Table with stripped rows -->

        <table class="table datatable borderless w-100" id="allConstraintTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Constraint Name</th>
                    <th>Constraint Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($constraints as $constraint)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $constraint->constraint_name }}</td>
                    <td>{{ $constraint->constraint_value }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item d-flex align-items-center" href="{{route('constraint-view', $constraint->constraint_id)}}"><span class="material-symbols-outlined">visibility</span> &nbsp View</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="{{route('constraint-edit', $constraint->constraint_id)}}"><span class="material-symbols-outlined">edit</span>&nbsp Edit</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="return confirm('Are you sure you want to delete this constraint?');"><span class="material-symbols-outlined">delete</span> &nbsp Delete</a></li>
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