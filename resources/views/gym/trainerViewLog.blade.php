@extends('layouts.userLayout')
@section('content')
<div class="page-title align-content-center justify-content-center mb-4">
    Gym Entry Log
</div>
<!-- Table with stripped rows -->
<div class="container ">
    <table class="table datatable  table borderless w-100 p-2 rounded myIssues" id="allUserTable">
        <thead>
            <tr>
                <th>Entered At</th>
                <th>Left At</th>
                <th>TP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $user->entered_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>{{str_replace('@mail.apu.edu.my','',$user->gymUser->user->email)}} </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
</div>
<!-- End Table with stripped rows -->
@endsection