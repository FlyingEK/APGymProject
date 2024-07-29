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
            <img class="img-fluid equipmentImg" src="{{ asset('storage/'.$equipment->image) }}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 no-wrap">
                <h4>{{$equipment->name}}</h4>
                @php
                $color = $equipment->status == 'Available'? 'success' : 'danger';
                @endphp
                <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none" style="font-size: 13px;">
                    {{$equipment->status}}
                </div><br>
            </div>
        </div>
        <hr>
    </div>
    <div class="row">
        <div class="row mb-3">
            <div class="label mb-3">Instructions:</div>
            <ul>
                @if ($equipment->tutorials->isEmpty())
                <li>No instruction available</li>
                @endif
                @foreach ($equipment->tutorials as $tutorial)
                    <li class="mb-3">{{ $loop->iteration }}. {{ $tutorial->instruction }}</li>
                @endforeach
            </ul>
        </div>
        <div class="row mb-4">
            <div class="label mb-3">Tutorial video:</div>
            @if ($equipment->tutorial_youtube)
            <iframe class="instructionVideo"
            src="{{$equipment->tutorial_youtube}}">
            </iframe>
            @endif
        </div>
    </div>
    {{-- @if($isCheckIn)
    <div class="row mb-4">
        <div class="  col-12 d-flex justify-content-end" style="gap:10px;">
            <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                Use
            </button>
        </div>
    </div>
    @endif --}}
</div>
@endsection