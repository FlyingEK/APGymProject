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
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td> <span style="font-size:11px;" class="p-1 rounded-pill text-white {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'trainer' ? 'bg-warning' : 'bg-info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        </td>
                        <td><span style="font-size:11px;" class="rounded-pill text-white p-1 {{ $user->status == 'active' ? 'bg-success' : ($user->status == 'inactive' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($user->status) }}
                        </span></td>
                        <td>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('user-view',$user->user_id)}}"><span class="material-symbols-outlined">edit</span>&nbsp View/Edit</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" onclick=""><span class="material-symbols-outlined">Deactivate</span> &nbsp Delete</a></li>
    
                                </ul>
                            </div>
                        </td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</section>

@endsection

<script>
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            // Add delete logic here
        }
    }
</script>
