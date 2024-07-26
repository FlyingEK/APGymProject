@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Add User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user-all') }}">User</a></li>
            <li class="breadcrumb-item active">Add Gym Trainer</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>Trainer Details</h1>
    </div>
    <form method="POST" action="{{ route('user-store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                    <label for="floatingInput">First Name <span class="text-danger">*</span></label>
                    @error('first_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                    <label for="floatingInput">Last Name <span class="text-danger">*</span></label>
                    @error('last_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <label for="floatingInput">Username <span class="text-danger">*</span></label>
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                    <label for="floatingInput">Email</label>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <label for="formSelect">Role<span class="text-danger">*</span></label>
                    <div class="custom-select">
                        <select class="form-control form-select select" name="role" required>
                            <option selected>Choose...</option>
                            <option value="trainer">Gym Trainer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-lg-12 mt-3 mb-3 mr-4 text-end">
                <button class="btn redBtn" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection
