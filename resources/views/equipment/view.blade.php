@extends('layouts.layout')
@section('content')

<div class="container px-3 py-2 bg-white myShadow equipmentDetail">
    <div class="row">
        <div class="col-5 ">
                <img class="img-fluid equipmentImg" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 no-wrap">
                <h4>Equipment name</h4>
                <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none" style="font-size: 13px;">
                    <i class="fa-solid fa-helmet-safety"></i> Available
                </div><br>
            </div>
        </div>
        <hr>
    <div class="row">
        <div class="row mb-3">
            <div class="label mb-3">Instructions:</div>
            @for ($i = 0; $i < 3; $i++)
                <div class="value mb-1">1 Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum </div>
            
            @endfor
        </div>
        <div class="row mb-4">
            <div class="label mb-3">Tutorial video:</div>
            <iframe class="instructionVideo"
            src="https://www.youtube.com/embed/tgbNymZ7vqY">
            </iframe>
        </div>
    </div>
    <div class="row mb-4">
        <div class="  col-12 d-flex justify-content-end" style="gap:10px;">
            <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                Use
            </button>
        </div>
    </div>
</div>
@endsection