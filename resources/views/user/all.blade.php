@extends('layouts.adminLayout')
@section('content')
<div class="pagetitle">
    <h1>User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">User</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="tableContainer">
    <div class="row">
        <div class="col-lg-12 col-lg-12 col-sm-12 d-flex">
            <div class="pagetitle align-content-center justify-content-center me-4">
                <h1>All Users</h1>
            </div>
            <a href="{{ route('user-create') }}" class="btn rounded-pill ms-2 submit-button ps-3 pe-3 pt-2 pb-2">
                <i class="fa fa-plus me-2"></i>
                Add User
            </a>
        </div>
        <!-- Table with stripped rows -->

        <table class="table datatable borderless w-100" id="allUserTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>{{$i}}</td>
                        <td>User Name</td>
                        <td>User Name</td>
                        <td>User Name</td>
                        <td>Description</td>
                        <td>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('user-view')}}"><span class="material-symbols-outlined">visibility</span> &nbsp View</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('user-edit')}}"><span class="material-symbols-outlined">edit</span>&nbsp Edit</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" onclick=""><span class="material-symbols-outlined">delete</span> &nbsp Delete</a></li>
    
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</section>

@endsection