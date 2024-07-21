@extends('layouts.userLayout')
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
                <div class="page-title no-wrap" style="padding-right: 0px;">My Reported Issues</div>
            </div> 
        </div>
        <div class="mt-1">
            <table class="bg-white mobileTable table borderless w-100 p-2 rounded myIssues" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @foreach ($userIssues as $issue)
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
                        <td>{{ $issue->created_at->format('d M Y') }} <a href="{{route('issue-user-view',$issue->issue_id)}}" class="stretched-link"></a></td>
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
                <div class="page-title no-wrap" style="padding-right: 0px;">Known Issues</div>
            </div>
        </div>

        <table class="table bg-white pureDatatable borderless w-100 myIssues" >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            @foreach ($knownIssues as $issue)
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
                    <td>{{ $issue->created_at->format('d M y')}}<a href="{{route('issue-user-view')}}" class="stretched-link"></a>
                    </td>
                    <td>{{ $issue->title }}</td>
                    <td><span class="rounded-pill text-white {{$color}} px-1" style=" font-size: 12px !important;">{{ ucfirst($issue->status) }}</td></td>
                        <td>
                        <a href="{{route('issue-user-view',$issue->issue_id)}}" class="stretched-link"></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-3" style="flex-direction: column;"> 
        <span class="text-center material-symbols-outlined icons" style="color:gray;font-size:50px;">construction</span>
        <p class="text-center page-title text-center">Found an issue that is not reported?</p>
        <a class="text-center redLink" href="{{route('issue-create')}}">Click here to report</a>
    </div>
    
</div>
@endsection

{{-- <style>
    .position-relative {
        position: relative;
    }

    .stretched-link::after {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 1;
        pointer-events: auto;
        content: '';
    }
</style> --}}
