@extends('layouts.userLayout')

@section('content')

<div class="content container p-1">
    <div class="backLink  mb-2">
        <a href="{{route('workout-index')}}">
            <i class="fas fa-chevron-left"></i><span>  Back</span>
        </a>
    </div>
    <div class="row mb-1">
        <div class="page-title" style="padding-right: 0px;">Defined Workout Habit</div>
    </div>

    <div class="row mb-3">
        @if($equipmentsWithHabit->isEmpty())
            <p class="mb-3">No workout habits found. Click the button to add one.</p>
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{route('workout-habit-add')}}" class="btn redBtn">Add Workout Habit</a>
                </div>
            </div>
        @endif
        
        <div class="d-flex align-items-center justify-content-start flex-row flex-wrap">
            @foreach ($equipmentsWithHabit as $item)
            <div style="width: 33%">
                <button class="card equipment d-flex flex-column align-items-center justify-content-center shadow-sm mt-2 p-2" data-bs-toggle="modal" data-bs-target="#habitModal{{ $item->equipment_id }}">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$item->image) }}" alt="Work Order Image" ><br/>
                    <p class="equipmentTitle">{{$item->name}}</p>
                </button>
            </div>
            @endforeach
        </div>
        @foreach ($equipmentsWithHabit as $item)

        <!-- Modal -->
        <div class="modal fade" id="habitModal{{ $item->equipment_id }}" tabindex="-1" aria-labelledby="habitModalLabel{{ $item->equipment_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="habitModalLabel{{ $item->equipment_id }}">Workout Habits for {{ $item->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(!$item->workout_habit_id)
                            <p>No workout habits found for this equipment.</p>
                        @else
                        <form id="update{{$item->workout_habit_id }}" action="{{ route('workout-habit-update', $item->workout_habit_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="has_weight" value="{{ $item->has_weight}}">
                            @if($item->set)
                            <div class="mb-3">
                                <label for="set{{ $item->workout_habit_id }}" class="form-label"><strong>Set:</strong></label>
                                <input type="number" class="form-control" id="set{{ $item->workout_habit_id }}" name="set" value="{{ $item->set }}" placeholder="Set">
                                @error('set')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="repetition{{ $item->workout_habit_id }}" class="form-label"><strong>Repetition:</strong></label>
                                <input type="number" class="form-control" id="repetition{{ $item->workout_habit_id }}" name="rep" value="{{ $item->repetition }}" placeholder="Repetition">
                                @error('repetition')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="weight{{ $item->workout_habit_id }}"><strong>Weight:</strong></label>
                                <input type="number" class="form-control" id="weight{{ $item->workout_habit_id }}" name="weight" value="{{ $item->weight }}" placeholder="Weight">
                                @error('weight')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="allow_sharing{{ $item->workout_habit_id }}"><strong>Allow Sharing: &nbsp;</strong></label>
                                <input type="hidden" name="allow_sharing" value="0">
                                <input type="checkbox" name="allow_sharing" value="1" {{ $item->allowSharing ? 'checked' : '' }}>
                            </div>
                        @endif
                        @if($item->duration)
                            <div class="mb-3">
                                <label for="duration{{ $item->workout_habit_id }}" class="form-label"><strong>Duration:</strong></label>
                                <input type="number" class="form-control" id="duration{{ $item->workout_habit_id }}" name="duration" value="{{ $item->duration }}" placeholder="Duration (minutes)">
                                @error('duration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="d-flex justify-content-end mt-3" style="gap:8px;">
                            <button type="submit" class="btn blueBtn d-inline">Save Changes</button>
                            <button type="button" class="btn redBtn" onclick="submitForm('delete-form-{{ $item->workout_habit_id }}')">Delete Habit</button>
                        </div>
                    </form>    
                    <form action="{{ route('workout-habit-delete', $item->workout_habit_id) }}" method="POST" id="delete-form-{{ $item->workout_habit_id }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                    </form>
                
                    @endif
                    </div>
                </div>
            </div>
        </div>

        @endforeach
        @if($equipmentsWithHabit)
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{route('workout-habit-add')}}" class="btn redBtn">Add Workout Habit</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
<script>
    function submitForm(formId) {
        swal.fire(
            {
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn redBtn',
                    cancelButton: 'btn blueBtn'
                },
                confirmButtonText: 'Yes, delete it!'
            }
        ).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
