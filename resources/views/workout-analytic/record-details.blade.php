@extends('layouts.userLayout')
@section('content')
{{-- <div class="backLink mb-2">
    <a href="{{route('equipment-index')}}">
        <i class="fas fa-chevron-left"></i><span>  Back</span>
    </a>
</div> --}}
<div class="container px-3 py-2 bg-white myShadow equipmentDetail">
    <div class="row">
        <div class="col-5 ">
            <img class="img-fluid equipmentImg" src="{{ asset('storage/'.$workout->equipmentMachine->equipment->image) }}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 no-wrap">
                <h4>{{$workout->equipmentMachine->equipment->name}}</h4>
                <p class="text-muted">{{$workout->date. "  ".$workout->start_time}}</p>
            </div>
        </div>
        <hr>
    </div>
    <div class="row">
        <div class="row mb-3">
            <div class="col-5 label">Duration:</div>
            <div class="col-7 value">{{$duration}}</div>
        </div>
        @if($workout->equipmentMachine->equipment->has_weight)
        <div class="row mb-3">
            <div class="col-5 label">Weight:</div>
            <div class="col-7 value">{{$workout->weight}}kg</div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Number of sets:</div>
            <div class="col-7 value">{{$workout->set}}</div>
        </div>
        <div class="row mb-3">
            <div class="col-5 label">Number of repetitions:</div>
            <div class="col-7 value">{{$workout->repetition}}</div>
        </div>
        @endif
    </div>
</div>
@endsection