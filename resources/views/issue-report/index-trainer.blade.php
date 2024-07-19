@extends('layouts.trainerLayout')
@section('content')
<div class="content container p-1">
    <div id="userIssue">
        <div class="row mt-4">
            <div class="col-12">
                <div class="page-title no-wrap" style="padding-right: 0px;">Open Issues</div>
            </div>
        </div>

        <div class="workoutSection mt-2">
            <table class="table workoutHistoryTable">
                @for($i = 0; $i < 2; $i++)
                    <tr class="position-relative">
                        <td class="w-60">$issueTitle</td>
                        <td class="w-30">$issueType</td>
                        <td class="w-10">$status</td>
                        <td>
                            <a href="{{route('issue-trainer-view')}}" class="stretched-link"></a>
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>

    <div id="knownIssue">
        <div class="row mt-4">
            <div class="col-6" style="padding-right: 0px;">
                <div class="page-title no-wrap" style="padding-right: 0px;">Closed Issues</div>
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
            <table class="table workoutHistoryTable">
                @for($i = 0; $i < 4; $i++)
                    <tr class="position-relative">
                        <td class="w-60">$issueTitle
                            <a href="{{route('issue-trainer-view')}}" class="stretched-link"></a>
                        </td>
                        <td class="w-30">$issueType</td>
                        <td class="w-10">$status</td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>


</div>
@endsection

