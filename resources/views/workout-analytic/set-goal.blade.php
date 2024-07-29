@extends('layouts.userLayout')
@section('content')
<div class="content goalContainer container inter p-1">
    <div class="backLink mb-2">
        <a href="{{route('analytic-report')}}">
            <i class="fas fa-chevron-left"></i><span>  Back</span>
        </a>
    </div>
    <div class="card mb-4">
        @php
            $goal_id = $overallGoal?$overallGoal->goal_id:0;
        @endphp
        <form action ="{{route('store-overall-goal',$goal_id)}}" method="post">
            @csrf
        <div class="row mt-1 mb-2">
            <div class="page-title" style="padding-right: 0px;">Overall Goals</div>
        </div>
        <table class="w-100 goalInput mb-3" style="border:none;">
            <tr>
                <th style="width:65%;">Targeted Workout Time</th>
                <th style="width:35%;">Per</th>
           
            <tr class="my-2">
                <td >
                    <input type="hidden" name="goal_id" {{$overallGoal?"value='$overallGoal->goal_id'":"value=''"}}>
                    <input type="text" name="workout_hour" placeholder="Workout hours" class="form-control" value="{{ $overallGoal ? $overallGoal->workout_hour : '' }}" />
                </td>
                <td>
                    <div class="custom-select">
                        <select name="per" class="form-select p-2" id="time" aria-label="time">
                            <option selected>Choose...</option>
                            <option value="week" {{$overallGoal && $overallGoal->per=="week"?"selected":""}}>Week</option>
                            <option value="month" {{$overallGoal && $overallGoal->per=="month"?"selected":""}}>Month</option>
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
    </form>
    </div>
    
    <div class="card mb-5">
        <form action ="{{route('store-strength-goal')}}" method="post">
            @csrf
        <div class="row mt-1 mb-2">
            <div class="page-title" style="padding-right: 0px;">Specific Goals</div>
        </div>

        <div class="row">
            <div class="col-12">
                <div>
                    <table class="w-100 goalInput mb-3" style="border:none;" id="dynamic_field_goal">
                        <tr>
                            <th style="width:60%;">Equipment</th>
                            <th style="width:35%;">Targeted Weight</th>
                            <th style="width:5%;"></th>
                        <tr class="my-2">
                                {{-- every row add a hidden rowid --}}
                                @if($strengthGoal->isNotEmpty())
                                @foreach($strengthGoal as $index => $goal)
                                <tr id="row{{ $index + 1 }}" class="my-2">
                                    <td > <select class="select2 form-control form-select mb-3" name="equipment_ids[]"  required>
                                        <option value="" data-has-weight="0" selected>Choose an equipment...</option>
                                        @foreach($allEquipment as $equip)
                                            <option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}" {{$goal->equipment_id == $equip->equipment_id?"selected":""}}>{{ $equip->name }}</option>
                                        @endforeach
                                    </select></td>
                                    <td><input type="number" name="goalValues[]" placeholder="Weight" class="form-control" value={{$goal->weight}} /></td>
                                    @if($index==0)
                                        <td><input type="hidden" name="goal_id" value="{{$goal->goal_id}}">
                                            <button type="button" id="addGoal" class="btn blueBtn" name="add" id="add">Add</button>
                                        </td>
                                    @else
                                        <td><button type="button" class="btn btn-danger btn_remove" id="{{ $index + 1 }}">X</button></td>
                                    @endif
                                    </tr>

                                @endforeach
                                @else
                                    <tr id="row0" class="my-2">
                                        {{-- <td><select class="select2 form-control form-select mb-3" name="equipment_ids[]" id="equipment-name2" required>
                                            <option value="" data-has-weight="0" selected>Choose an equipment...</option>
                                            @foreach($allEquipment as $equip)
                                                <option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}">{{ $equip->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="goalValues[]" placeholder="Weight" class="form-control" /></td> --}}
                                    <td></td><td></td>
                                    <td><button type="button" class="btn blueBtn" name="add" id="addGoal" style="padding: 6px 8px;">Add</button></td>  
                                    </tr>
                                @endif
                            </td>
                            
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
    </form>

    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('/js/custom-select-box.js') }}"></script>
<script src="{{ asset('/js/dynamic-input-field.js') }}"></script>

<script>
$(document).ready(function() {
    // $('#equipment-name2').select2({
    //     placeholder: 'Equipment',
    // });

    $('.select2').select2({
        placeholder: 'Equipment',
    });
   
    var i = {{ $strengthGoal? count($strengthGoal) : 1 }};
    var no = {{ $strengthGoal? count($strengthGoal) : 1 }};

   $("#addGoal").click(function(){
     i++;
     no++;
     console.log('hi');
     var newRow = '<tr id="row' + i + '">';
     newRow += '<td><select class="select2 form-control form-select mb-3" name="equipment_ids[]" id="equipment-name2'+i+' required>';
     newRow += '<option value="" data-has-weight="0" selected>Choose an equipment...</option>';
     @foreach($allEquipment as $equip)
         newRow += '<option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}">{{ $equip->name }}</option>';
     @endforeach
     newRow += '</select></td>';
     newRow += '<td><input type="hidden" name="goal_id" value="'+i+'"><input type="number" name="goalValues[]" placeholder="Weight" class="form-control" /></td>';
     newRow += '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td>';
     newRow += '</tr>';
     $('#dynamic_field_goal').append(newRow);
     $('.select2').select2({
        placeholder: 'Equipment',
    });
     });
 
   $(document).on('click', '.btn_remove', function(){  
       var button_id = $(this).attr("id");     
       no--;
       $('#row'+button_id+'').remove();  
     });
 });
 
 </script>

@stop



