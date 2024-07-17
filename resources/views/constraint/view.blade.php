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
                    <a onclick="confirmDelete()" class="btn redBtn">Deactive Constraint</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



