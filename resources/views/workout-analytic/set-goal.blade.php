@extends('layouts.userLayout')
@section('content')
<div class="content goalContainer container inter p-1">
    <div class="backLink mb-2">
        <a href="{{route('analytic-report')}}">
            <i class="material-symbols-outlined redIcon no-wrap">arrow_back_ios</i><span>  Back</span>
        </a>
    </div>
    <div class="card mb-4">
        <div class="row mt-1 mb-2">
            <div class="page-title" style="padding-right: 0px;">Overall Goals</div>
        </div>
        <table class="w-100 goalInput mb-3" style="border:none;">
            <tr>
                <th style="width:65%;">Targeted Workout Time</th>
                <th style="width:35%;">Per</th>
            <tr class="my-2">
                <td >
                    <input type="number" name="workoutTime" placeholder="Workout Time(hour)" class="form-control" />        </div>
                </td>
                <td>
                    <div class="custom-select">
                        <select class="form-select p-2" id="time" aria-label="time">
                            <option selected>Choose...</option>
                            <option value="Week">Week</option>
                            <option value="Month">Month</option>
                        </select>
                    </div>
                </td>          
            </tr>
        </table>
        <div class="row">
            <div class="col-12 mt-3 mb-2 mr-4 text-end">
                <button class="btn redBtn" type="submit">Submit</button>
            </div>
        </div>
    </div>
    
    <div class="card mb-5">
        <div class="row mt-1 mb-2">
            <div class="page-title" style="padding-right: 0px;">Specific Goals</div>
        </div>

        <div class="row">
            <div class="col-12">
                <div>
                    <table class="w-100 goalInput mb-3" style="border:none;" id="dynamic_field_goal">
                        <tr>
                            <th style="width:45%;">Equipment</th>
                            <th style="width:45%;">Targeted Goal</th>
                            <th></th>
                        <tr class="my-2">
                            <td >
                                <div class="custom-select">
                                    <select class="form-select p-2" name="equipment[]" id="equipmentType" aria-label="Equipment Type">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </td>
                            <td style="width:15%;"><input type="number" name="goalValue[]" placeholder="Duration/Weight" class="form-control" /></td>
                            <td><button type="button" class="btn blueBtn" name="add" id="addGoal" style="padding: 6px 8px;">Add</button></td>  
                        </tr>
                    </table>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-12 mt-3 mb-2 mr-4 text-end">
                <button class="btn redBtn"  type="submit">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('/js/custom-select-box.js') }}"></script>
<script src="{{ asset('/js/dynamic-input-field.js') }}"></script>

@stop



