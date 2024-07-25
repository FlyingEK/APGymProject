@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Add Achievement Badge</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('achievement-all') }}">Achievement Badge</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>Constraint Details</h1>
    </div>
    <form action="{{route('achievement-update', $achievement->achievement_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" name="condition" class="form-control" id="floatingInput" value="{{ $achievement->condition}}">
                    <label for="floatingInput">Achievement Condition <span class="text-danger">*</span></label>
                </div>
                @error('condition')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="defect-upload m-3">
                    <div style="font-size:14px;">
                        Achievement Badge Image  <span class="text-danger">*</span>
                    </div>
                    <div class="avatar-upload add-asset-upload">
                        <div class="avatar-edit">
                            <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" >
                             <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview" style="background-image: url(/storage/{{$achievement->image}});"></div>
                        </div>
                    </div>
                     @error('image')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                 </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mt-3 mb-3 mr-4 text-end">
                <button class="btn redBtn" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection
@push('script')
<script src="{{ asset('/js/img-preview.js') }}"></script>
@endpush


