@extends('layouts.userLayout')
@section('content')
<div class="container px-3 py-2 bg-white myShadow rounded">
    <h3 class=" mb-4">{{$issue->title}}</h3>
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
            }elseif($issue->status == 'cancelled') {
                $color = 'bg-secondary';
            }

        @endphp
        <div class="row mb-4">
            <div class="col-5 label">Status:</div>
            <div class="col-7 ">
                <span class=" badge {{ $color}} rounded-pill">Pending</span>
            </div>
        </div>
        @if($issue->comment)
        <div class="row mb-3 d-flex justify-content-center">
            <div class="text-success">Reply: {{$issue->comment->comment}}</div>
        </div>
        <div class="row mt-4 mb-3">
            <div class="  col-12 d-flex justify-content-end" style="gap:10px;">
                @if ($issue->status == 'pending')
                    <a href="{{ route('issue-edit', $issue->issue_id) }}" class="btn formBtn myBtn blueBtn">Edit</a>
                    <form action="{{ route('issue-cancel', $issue->issue_id) }}" method="POST" id="cancelIssueForm" >
                        @csrf
                        @method('PUT')
                        <button type="submit" id="cancelIssue" class=" btn formBtn myBtn redBtn">Cancel</button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('cancelIssue').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to cancel this issue!",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn redBtn',
                    cancelButton: 'btn blueBtn'
                },
                confirmButtonText: 'Yes, Cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('cancelIssueForm').submit();
                }
            });
        });
    });
</script>
@endsection