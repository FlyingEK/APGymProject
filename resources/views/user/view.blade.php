@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>View User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user-all') }}">User</a></li>
            <li class="breadcrumb-item active">View User</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="row mr-3">
        <div class="col-lg-6 col-md-6 ">
            <div class="pagetitle p-3">
                <h1>User Details</h1>
            </div>
        </div>
        @php
        $status = 'active'; // TEMP DATA
            $statusColor = $status == 'active' ? 'bg-success' : 'bg-secondary';
        @endphp
        <div class="col-lg-6 col-md-6 d-flex justify-content-end align-items-center">
            <span class="badge {{$statusColor}} rounded-pill mx-3" style="font-size:15px;">Status</span>
        </div>
    </div>
    <div class="row m-3">
        <div class="col-lg-12">
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Username:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Email:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Role:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-12 d-flex justify-content-end gap-2">
                    <a href="{{route('user-edit')}}" class="btn blueBtn">Edit</a>
                    <a onclick="confirmDelete()" class="btn redBtn">Deactive User</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



