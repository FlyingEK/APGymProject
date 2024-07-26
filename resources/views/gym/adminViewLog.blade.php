@extends('layouts.adminLayout')
@section('content')
<div class="pagetitle">
    <h1>Gym Entry Log</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Gym Entry Log</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="tableContainer">
    <div class="row">
        <div class="col-lg-12 col-lg-12 col-sm-12 d-flex">
            <div class="pagetitle align-content-center justify-content-center me-4">
                <h1>Gym Entry Log</h1>
            </div>
        </div>
        <!-- Table with stripped rows -->

        <table class="table datatable borderless w-100" id="allUserTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Entered At</th>
                    <th>Left At</th>
                    <th>Name</th>
                    <th>TP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->entered_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td> {{ $user->gymUser->user->first_name }} {{ $user->gymUser->user->last_name  }}
                        </td>
                        <td>{{str_replace('@mail.apu.edu.my','',$user->gymUser->user->email)}} </td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</section>

@endsection


