@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Edit Gym Constraint</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('constraint-all') }}">Gym Constraint</a></li>
            <li class="breadcrumb-item"><a href="{{ route('constraint-view', $constraint->constraint_id) }}">{{$constraint->constraint_name}}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>Constraint Details</h1>
    </div>
    <form action="{{route('constraint-update', $constraint->constraint_id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" name="constraint_name" class="form-control" id="floatingInput" value="{{ $constraint->constraint_name}}">
                    <label for="floatingInput">Constraint Name <span class="text-danger">*</span></label>
                </div>
            </div>
        </div>

         <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" name="constraint_value"  class="form-control" id="floatingInput" value="{{ $constraint->constraint_value}}" >
                    <label for="floatingInput">Constraint Value <span class="text-danger">*</span></label>
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



