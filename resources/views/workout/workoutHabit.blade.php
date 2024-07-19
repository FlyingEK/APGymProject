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
        @if($equipmentWithHabits->isEmpty())
            <p class="mb-3">No workout habits found. Click the button to add one.</p>
        @endif
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{route('workout-habit-add')}}" class="btn redBtn">Add Workout Habit</a>
            </div>
        </div>
        @foreach ($equipmentWithHabits as $item)
        <div class="col-4">
            <button class="card equipment shadow-sm mt-2 p-2">
                <div class="row">
                    <div class="col-5 ">
                       <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$item->image) }}" alt="Work Order Image" ><br/>
                    </div>
                    <div class="col-7" style="padding-left: 5px">
                        <div class=" mt-md-3 no-wrap">
                            <p class="equipmentTitle">{{$item->name}}</p>
                        </div>
                    </div>
                </div>
            </button>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="habitModal{{ $item->id }}" tabindex="-1" aria-labelledby="habitModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="habitModalLabel{{ $item->id }}">Workout Habits for {{ $item->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($item->workoutHabits->isEmpty())
                            <p>No workout habits found for this equipment.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($item->workoutHabits as $habit)
                                    <li class="list-group-item">
                                        <strong>Workout Habit ID:</strong> {{ $habit->id }}<br>
                                        @if($habit->strengthWorkoutHabit)
                                            <strong>Strength Workout:</strong><br>
                                            Set: {{ $habit->strengthWorkoutHabit->set }}<br>
                                            Repetition: {{ $habit->strengthWorkoutHabit->repetition }}<br>
                                            Weight: {{ $habit->strengthWorkoutHabit->weight }}<br>
                                        @endif
                                        @if($habit->cardioWorkoutHabit)
                                            <strong>Cardio Workout:</strong><br>
                                            Duration: {{ $habit->cardioWorkoutHabit->duration }}<br>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('workout-habits.create') }}" class="btn btn-primary">Add Workout Habit</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@include('partials.equipment.create-habit-modal')
@endsection
{{-- @section("javascript")

@endsection --}}