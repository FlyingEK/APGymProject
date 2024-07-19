@extends('layouts.trainerLayout')
@section('content')
<div class="container px-3 py-2 bg-white myShadow rounded">
    <h3 class=" mb-4">Issue Details</h3>
    <div class="row">
        <div class="row mb-3">
            <div class="col-5 label">Request Name:</div>
            <div class="col-7 value">Request Name</div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Issue Type:</div>
            <div class="col-7 value">Maintenance Type</div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Request Description:</div>
            <div class="col-7 value">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum </div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Attach Image:</div>
            <div class="col-7">
                <img src="https://via.placeholder.com/150" alt="Preview Image" class="image-preview">
            </div>        
        </div>
        @php
            $status_color = "";

            // if ($Model->Status == "Pending") {
            //     $status_color = "bg-info";
            // } elseif ($Model->Status == "Reported") {
            //     $status_color = "bg-primary";
            // } elseif ($Model->Status == "Rejected") {
            //     $status_color = "bg-danger";
            // } elseif ($Model->Status == "Maintenance Ongoing") {
            //     $status_color = "bg-warning";
            // } elseif ($Model->Status == "Completed") {
            //     $status_color = "bg-success";
            // } elseif ($Model->Status == "Cancelled") {
            //     $status_color = "bg-secondary";
            // }
        @endphp
        <div class="row mb-4">
            <div class="col-5 label">Status:</div>
            <div class="col-7 ">
                <span class=" badge {{ $status_color}}  bg-danger rounded-pill">Pending</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="text-secondary">Reported by Neong Yee Kay on 19/07/2024</div>
        </div>
        <div class="row mt-4 mb-3">
            <div class="  col-12 d-flex justify-content-end" style="gap:10px;">
                <a href="{{ route('issue-edit') }}" class="btn formBtn myBtn blueBtn">Update Status</a>
                <button type="submit" class=" btn formBtn myBtn redBtn">Reject</button>
            </div>
        </div>
    </div>
</div>
@endsection
