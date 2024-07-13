@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Add Gym Constraint</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('constraint-all') }}">Gym Constraint</a></li>
            <li class="breadcrumb-item active">Add Gym Constraint</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>Constraint Details</h1>
    </div>
    <form>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="" required>
                    <label for="floatingInput">Constraint Name <span class="text-danger">*</span></label>
                </div>
            </div>
        </div>

         <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="" >
                    <label for="floatingInput">Constraint Value</label>
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



