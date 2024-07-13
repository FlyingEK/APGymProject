@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    <div class="report-filter">
        <a href="{{route('equipment-index')}}">
            <i class="material-symbols-outlined redIcon no-wrap">home</i><span>  Home</span>
        </a>
    </div>
    <div id="userIssue">
        <div class="row mt-4">
            <div class="col-6" style="padding-right: 0px;">
                <div class="page-title no-wrap" style="padding-right: 0px;">My Reported Issues</div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div class="report-filter">
                    <a href="#">
                        <i class="material-symbols-outlined redIcon no-wrap">tune</i><span>  Today</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="workoutSection mt-2">
            <div class="workoutHistoryDate">06 June 2024</div>
            <table class="table workoutHistoryTable">
                @for($i = 0; $i < 2; $i++)
                    <tr class="position-relative">
                        <td class="w-60">$issueTitle</td>
                        <td class="w-30">$issueType</td>
                        <td class="w-10">$status</td>
                        <td>
                            <a href="{{route('issue-user-view')}}" class="stretched-link"></a>
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>

    <div id="knownIssue">
        <div class="row mt-4">
            <div class="col-12">
                <div class="page-title no-wrap" style="padding-right: 0px;">Known Issues</div>
            </div>
        </div>

        <div class="workoutSection mt-2">
            <table class="table workoutHistoryTable">
                @for($i = 0; $i < 4; $i++)
                    <tr class="position-relative">
                        <td class="w-60">$issueTitle
                            <a href="{{route('issue-user-view')}}" class="stretched-link"></a>
                        </td>
                        <td class="w-30">$issueType</td>
                        <td class="w-10">$status</td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center" style="flex-direction: column;"> 
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
