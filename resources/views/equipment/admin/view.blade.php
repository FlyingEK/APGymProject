@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>View Equipment</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('equipment-all') }}">Equipment</a></li>
            <li class="breadcrumb-item active">View Equipment</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>Equipment Details</h1>
    </div>
    <div class="row m-3">
        <div class="col-lg-12">
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Equipment Name:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Description:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Has Weight:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Quantity:</div>
                <div class="col-lg-9 col-md-8"></div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Equipment Image:</div>
                <div class="col-lg-9 col-md-8">
                    <img src="{{ asset('/img/treadmill.jpg') }}" alt="Equipment Image" class="adminImg img-fluid">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Tutorial Instructions:</div>
                <div class="col-lg-9 col-md-8">
                    <ul> 
                        {{-- @foreach ($equipment->instructions as $instruction)
                            <li>{{ $instruction }}</li>
                        @endforeach --}}
                        <li>111</li>
                        <li>222</li>
                    </ul>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-4 label">Tutorial Video:</div>
                <div class="col-lg-9 col-md-8">
                    <iframe id="video-preview" width="380" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen src="https://www.youtube.com/embed/"></iframe>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-12 d-flex justify-content-end gap-2">
                    <a href="{{route('equipment-edit')}}" class="btn blueBtn">Edit</a>
                    <a onclick="confirmDelete()" class="btn redBtn">Delete</a>
                </div>
        </div>
    </div>
</div>

@endsection


