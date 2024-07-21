@extends('layouts.userLayout')
@section('content')
<div class="content goalContainer container inter p-1">
    <div class="backLink mb-2">
        <a href="{{route('analytic-report')}}">
            <i class="fas fa-chevron-left"></i><span>  Back</span>
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
                            <th style="width:35%;">Equipment</th>
                            <th style="width:45%;">Targeted Goal</th>
                            <th></th>
                        <tr class="my-2">
                            <td >
                                <select class="select2 form-control form-select mb-3" name="equipment_ids[]" id="equipment-name2" required>
                                    <option value="" data-has-weight="0" selected>Choose an equipment...</option>
                                    @foreach($allEquipment as $equip)
                                        <option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}">{{ $equip->name }}</option>
                                    @endforeach
                                </select>
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

<script>
$(document).ready(function() {
    $('#equipment-name2').select2({
        placeholder: 'Equipment',
    });
     $('#equipment-name2').on('change', function() {
        //  var hasWeight = $(this).find(':selected').data('has-weight');
        //  if (hasWeight == 1) {
        //    $('#goalvalue').attr('placeholder', 'Number of Repetitions for ' + selectedOption.text());

        //  } else {
        //      $('#weight-fields').addClass('d-none');
        //      $('#duration-field').removeClass('d-none');
        //  }
     });
   
   var i = 1;
   var no =1;
   $("#addGoal").click(function(){
     i++;
     no++;
     var newRow = '<tr id="row' + i + '">';
     newRow += '<td ><select class="form-control form-select select2 mb-3" name="equipment_ids[]" id="equipment-name2' + i + '" required>';
     newRow += '<option value="" data-has-weight="0" selected>Choose an equipment...</option>';
     @foreach($allEquipment as $equip)
         newRow += '<option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}">{{ $equip->name }}</option>';
     @endforeach
     newRow += '</select></td>';
     newRow += '<td><input type="number" name="goalValue[]" placeholder="Duration/Weight" class="form-control" /></td>';
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



