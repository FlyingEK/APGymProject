@extends('layouts.userLayout')
@section('content')


<div class="backLink  mb-2">
    <a href="{{route('workout-index')}}">
        <i class="fas fa-chevron-left"></i><span>  Back</span>
    </a>
</div>
<div class="container px-3 py-2 bg-white my-shadow rounded" class="mt-3">
        <div class="form-title mb-4">Workout Habit</div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="form-container">
                    <form id="habitForm" class="issueForm" method="POST">
                        @csrf
                        <select class="form-control form-select mb-3" name="equipment_id" id="equipment-name" required>
                            <option value="" data-has-weight="0" selected>Choose an equipment...</option>
                            @foreach($allEquipment as $equip)
                                <option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}">{{ $equip->name }}</option>
                            @endforeach
                        </select>
                        <div id="weight-fields" class="mt-3 mb-3 d-none">
                            <div class="mb-3">
                                <input type="number" class="form-control p-2" id="reps" name="reps" placeholder="Number of Repititions" aria-label="Number of Repetitions">
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control p-2" id="sets" name="sets" placeholder="Number of Sets" aria-label="Number of Sets">
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control p-2" id="weights" name="weights" placeholder="Weights (kg)" aria-label="Weights (kg)">
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="allowSharing" style="   font-size: 15px;">Allow Sharing &nbsp;
                                    <input type="checkbox" id="allowSharing" name="allowSharing" />
                                </label>
                            </div>
                        </div>
                        <div id="duration-field" class=" mt-3 mb-3 d-none">
                            <input type="number" class="form-control p-2" id="duration" name="duration" placeholder="Duration (minutes)" aria-label="Duration">
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn midBtn redBtn">Save</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
</div>

@endsection
@section('javascript')

<script>

$(document).ready(function() {
    $('#equipment-name').select2({
        placeholder: 'Select an equipment',
    });
     $('#equipment-name').on('change', function() {
         var hasWeight = $(this).find(':selected').data('has-weight');
         if (hasWeight == 1) {
             $('#weight-fields').removeClass('d-none');
             $('#duration-field').addClass('d-none');
         } else {
             $('#weight-fields').addClass('d-none');
             $('#duration-field').removeClass('d-none');
         }
     });
 });
 
 </script>
 @endsection