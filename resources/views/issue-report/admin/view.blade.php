@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Reported Issue</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href={{route('issue-reported')}}>Reported Issue</a></li>
            <li class="breadcrumb-item active">{{$issue->title}}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container rounded-2 shadow" style="background-color:white;position: relative;font-size:14px;">
    <div class="pagetitle p-3">
        <h1>Issue Details</h1>
    </div>
    <div class="row">
        <div class="row mb-3">
            <div class="col-5 label">Issue Title:</div>
            <div class="col-7 value">{{$issue->title}}</div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Issue Type:</div>
            <div class="col-7 value">{{ucfirst($issue->type)}}</div>
        </div>
        @if($issue->equipment_machine_id)
            <div class="row mb-3">
                <div class="col-5 label">Equipment:</div>
                <div class="col-7 value">{{$issue->equipmentMachine->equipment->name}}  #{{$issue->equipmentMachine->label}}</div>
            </div>
        @endif
        <div class="row mb-3">
            <div class="col-5 label">Description:</div>
            <div class="col-7 value">{{$issue->description}}</div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Attach Image:</div>   
            <div class="col-7">
                @if ($issue->image)
                <img style="height: 100px; object-fit:contain;" src={{asset("storage/".$issue->image)}} alt="Preview Image" class="image-preview">
                @else
                No Image Attached
                @endif
            </div>      
        </div>
        @php

            $color = '';
            
            if ($issue->status == 'resolved') {
                $color = 'bg-success';
            } elseif ($issue->status == 'pending') {
                $color = 'bg-warning';
            }elseif ($issue->status == 'reported') {
                $color = 'bg-info';
            } elseif($issue->status == 'rejected') {
                $color = 'bg-danger';
            }

        @endphp
        <div class="row mt-2 mb-4">
            <div class="col-5 label">Status:</div>
            <div class="col-7 ">
                <span class=" badge {{ $color}} rounded-pill">{{$issue->status}}</span>
            </div>
        </div>
        <div class="row mb-3 d-flex justify-content-center">
            <div class="text-secondary">Reported by {{$user->user->first_name}} {{$user->user->last_name }} on {{$issue->created_at->format('d M y H:m')}}</div>
        </div>
        @if($issue->comment)
        <div class="row mb-3 d-flex justify-content-center">
            <div class="text-success">{{$issue->comment->user->last_name}} replied: {{$issue->comment->comment}}</div>
        </div>
        @endif
        <div class="row mt-4 mb-3">
            <div class="  col-12 d-flex justify-content-end" style="gap:10px;">
                @if ($issue->status == "pending" || $issue->status == "reported")
                    <button class="btn formBtn myBtn blueBtn" data-bs-toggle="modal"  data-bs-target="#updateIssueModal">Update Status</button>
                @endif
                @if ($issue->status == "pending")
                    <button type="submit" data-bs-toggle="modal" data-bs-target="#rejectIssueModal" class=" btn formBtn myBtn redBtn">Reject</button>
                    @endif

            </div>
        </div>
    </div>
</div>




@include('issue-report.update-status-modal')
@include('issue-report.reject-issue-modal')

@endsection
@push('script')
<script>
    $('.select2').select2({
        minimumResultsForSearch: -1
    });
</script>
@endpush

