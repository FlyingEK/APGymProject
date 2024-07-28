@extends('layouts.adminLayout')
@section('content')
<div class="pagetitle">
    <h1>Reported Issue</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Reported Issue</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="tableContainer">
    <div class="row">
        <div class="col-lg-12 col-sm-12 d-flex">
            <div class="pagetitle align-content-center justify-content-center me-4">
                <h1>All Reported Issuess</h1>
            </div>
        </div>
        <!-- Table with stripped rows -->

        <table class="bg-white datatable table borderless w-100 p-2 rounded myIssues" >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            @foreach ($openIssues as $issue)
            @php
                    $color = '';
                
                    if ($issue->status == 'resolved') {
                        $color = 'bg-success';
                    } elseif ($issue->status == 'pending') {
                        $color = 'bg-warning';
                    }elseif ($issue->status == 'reported') {
                        $color = 'bg-info';
                    } elseif($issue->status == 'rejected') {
                        $color = 'bg-danger';
                    }elseif($issue->status == 'cancelled') {
                        $color = 'bg-secondary';
                    }
                @endphp
                <tr class="position-relative">
                    <td>{{ $issue->created_at->format('d M Y') }} <a href="{{route('issue-admin-view',$issue->issue_id)}}" class="stretched-link"></a></td>
                    <td>{{ $issue->title }}</td>
                    <td>{{ $issue->type }}</td>
                    <td><span class="rounded-pill text-white {{$color}} px-1" style=" font-size: 12px !important;">{{ ucfirst($issue->status) }}</td></td>
                    </tr>
            @endforeach
        </table>
        <!-- End Table with stripped rows -->
    </div>
</section>

@endsection

