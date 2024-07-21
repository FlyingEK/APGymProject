@extends('layouts.trainerLayout')
@section('content')
<div class="content container p-1">
    <div class="backLink">
        <a href="{{route('equipment-index')}}">
            <i class="material-symbols-outlined redIcon no-wrap">home</i><span>  Home</span>
        </a>
    </div>
    <div id="userIssue">
        <div class="row mt-4">
            <div class="col-12" style="padding-right: 0px;">
                <div class="page-title no-wrap" style="padding-right: 0px;">Open Issues</div>
            </div> 
        </div>
        <div class="mt-1">
            <table class="bg-white pureDatatable table borderless w-100 p-2 rounded myIssues" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @foreach ($openIssues as $issue)
                    @php
                        $color = '';
                    
                        if ($issue->status == 'pending') {
                            $color = 'bg-warning';
                        }elseif ($issue->status == 'reported') {
                            $color = 'bg-info';
                        }
                    @endphp
                    <tr class="position-relative">
                        <td>{{ $issue->created_at->format('d M Y') }} <a href="{{route('issue-trainer-view',$issue->issue_id)}}" class="stretched-link"></a></td>
                        <td>{{ $issue->title }}</td>
                        <td><span class="rounded-pill text-white {{$color}} px-1" style=" font-size: 12px !important;">{{ ucfirst($issue->status) }}</td></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div id="knownIssue">
        <div class="row mt-4">
            <div class="col-12">
                <div class="page-title no-wrap" style="padding-right: 0px;">Closed Issues</div>
            </div>
        </div>

        <table class="table bg-white mobileTable borderless w-100 myIssues" >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            @foreach ($closedIssues as $issue)
                @php
                     $color = '';
                    
                    if ($issue->status == 'resolved') {
                        $color = 'bg-success';
                    }
                @endphp
                <tr class="position-relative">
                    <td>{{ $issue->created_at->format('d M y')}}<a href="{{route('issue-trainer-view',$issue->issue_id)}}" class="stretched-link"></a>
                    </td>
                    <td>{{ $issue->title }}</td>
                    <td><span class="rounded-pill text-white {{$color}} px-1" style=" font-size: 12px !important;">{{ ucfirst($issue->status) }}</td></td>
                    </tr>
            @endforeach
        </table>
    </div>

    <div id="knownIssue">
        <div class="row mt-4">
            <div class="col-12">
                <div class="page-title no-wrap" style="padding-right: 0px;">Rejected Issues</div>
            </div>
        </div>

        <table class="table bg-white mobileTable borderless w-100 myIssues" >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            @foreach ($rejectedIssues as $issue)
                @php
                     $color = '';
                    
                    if ($issue->status == 'rejected') {
                        $color = 'bg-danger';
                    }
                @endphp
                <tr class="position-relative">
                    <td>{{ $issue->created_at->format('d M y')}}<a href="{{route('issue-trainer-view',$issue->issue_id)}}" class="stretched-link"></a>
                    </td>
                    <td>{{ $issue->title }}</td>
                    <td><span class="rounded-pill text-white {{$color}} px-1" style=" font-size: 12px !important;">{{ ucfirst($issue->status) }}</td></td>
                    </tr>
            @endforeach
        </table>
    </div>

    
</div>
@endsection

