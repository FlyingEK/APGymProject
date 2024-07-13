@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Add User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user-all') }}">User</a></li>
            <li class="breadcrumb-item active">Add User</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>User Details</h1>
    </div>
    <form>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="" required>
                    <label for="floatingInput">Username <span class="text-danger">*</span></label>
                </div>
            </div>
        </div>

         <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="" >
                    <label for="floatingInput">Email</label>
                </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <label for="formSelect">Role<span class="text-danger">*</span></label>
                    <div class="custom-select">
                        <select class="form-control form-select select" id="formSelect" placeholder="" required>
                            <option value="">Choose...</option>
                            <option value="trainer">Gym Trainer</option>
                            <option value="user">Gym User</option>
                        </select>
                    </div>
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



