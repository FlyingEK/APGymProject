<div class="modal fade" id="endWorkout" tabindex="-1" aria-labelledby="viewEquipmentHabitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: white; border: none;">
            <div class="modal-header border-bottom-0">
                <div class="pagetitle">
                    <h1>Finish Workout</h1>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 20px"></button>
            </div>
            <div class="modal-body border-0">
                <div class="form-container">
                    <form action="{{route('workout-end')}}" method="POST">
                        @csrf
                        @method('PUT')
                    <input type ="hidden" id="modalSet" name="set" value="">
                    <input type="hidden" id="modalDuration" name="duration" value="">
                    <input type="hidden" name="workout_id" value="{{$workout->workout_id}}">
                    @if($workout->equipmentMachine->equipment->has_weight)
                    <p>Please confirm the workout details for this workout</p>
                    <label for="weight" class="form-label"><strong>Weight:</strong></label>
                    <input type="text" name="weight" id="weight" value="{{$workout->workoutQueue->weight}}" class="form-control ">
                    {{-- <label for="rep" class="form-label"><strong>Repetition:</strong></label>
                    <input type="text" name="rep" id="rep" value="{{$workout->workoutQueue->repetition}}" class="form-control "> --}}
                    @endif
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn redBtn">
                            End Workout
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#habitModal').on('submit',function(e){
        console.log("HI");
        e.preventDefault();
        swal.fire({
            text: "Do you want to save this workout plan to your workout habit? You can manage your workout habit in Workout tab later.",
            icon: "question",
            showCancelButton: true,
            cancelButtonText: "Not for this time",
            confirmButtonText: "Save",
            customClass: {
                confirmButton: 'btn redBtn',
                cancelButton: 'btn blueBtn'
            },
        }).then((result)=>{
            const form = document.getElementById('habitModal');

            if(result.isConfirmed){
                if(form){
                    form.setAttribute('action', '{{ route("workout-add", 1) }}');
                    form.submit();
                }else{
                    console.error('habitModal not found');
                }
            }else{
                if(form){
                    form.setAttribute('action', '{{ route("workout-add", 0) }}');
                    form.submit();
                }else{
                    console.error('habitModal not found');
                }
            }
        });
    })
</script>
