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
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipment as $index => $equip)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $equip->name }}</td>
                        <td>{{ $equip->description??"N/A" }}</td>
                        <td>{{ $equip->has_weight ? 'Weight Machine' : 'Cardio' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('equipment-admin-view', $equip->equipment_id) }}"><span class="material-symbols-outlined">visibility</span> &nbsp View</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('equipment-edit', $equip->equipment_id) }}"><span class="material-symbols-outlined">edit</span>&nbsp Edit</a></li>
                                    <li>
                                        <form action="{{ route('equipment-edit', $equip->equipment_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                                            @csrf
                                           {{-- quantity 0 --}}
                                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                                <span class="material-symbols-outlined">delete</span> &nbsp Delete
                                            </button>
                                        </form>
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
