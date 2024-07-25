<div>
    <div class="row mt-4">
        <div class="col-6 ">
            <div class="page-title" style="padding-right: 0px;">Workout History</div>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <div class="report-filter">
                <a href="#">
                    <input type="date" wire:model="endDate" class="form-control " id="date" name="date" x-on:change="$wire.setDate( $event.target.value)"

                    placeholder="Select a date">

                    {{-- <i class="material-symbols-outlined redIcon no-wrap">tune</i><span>  Today</span> --}}
                </a>
            </div>
        </div>
    </div>


    <div class="workoutSection mt-2">
        @forelse ($workoutRecords as $date => $records)
        <div class="workoutHistoryDate">{{ $date }}</div>
        <table class="table workoutHistoryTable">
            @foreach ($records as $record)
            <tr>
                <td style="width:60%;"><a href={{route('workout-detail',$record['workout_id'])}} class="stretched-link"></a>{{ $record['equipment_machine']['equipment']['name']}}</td>
                <td style="width:35%;">{{ $record['duration'] }} minutes</td>
                <td tyle="width:5%;"><span class="material-symbols-outlined">chevron_right</span></td>
            </tr>
            
            @endforeach
        </table>
        @empty
        @if($isFilter)
        <div class="text-center">No workout records found</div>
        @else
        <div class="text-center">No workout records found for the past 7 days</div>
        @endif
        @endforelse
    </div>

</div>