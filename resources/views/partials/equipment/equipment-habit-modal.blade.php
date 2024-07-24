<div class="modal fade" id="viewEquipmentHabit" tabindex="-1" aria-labelledby="viewEquipmentHabitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: white; border: none;">
            <div class="modal-header border-bottom-0">
                <div class="pagetitle">
                    <h1>Workout Plan</h1>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 20px"></button>
            </div>
            <div class="modal-body border-0">
                <div class="form-container">
                       {{-- if habit exist -> update, else create: action --}}
                    <form id="habitModal" action="" class="issueForm" method="POST">
                        @csrf
                        <div class="d-flex align-items-center loading">
                            <strong>Loading...</strong>
                            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                          </div>
                          <input type="hidden" id="formMethod" name="_method" value="">
                        <input type="hidden" name="equipment_id" id="equipment_id" >
                        <input type="hidden" name="workout_habit_id" id="workout_habit_id" >
                        <input type="hidden" name="has_weight" id="has_weight" >
                        <div class="hasWeightInput d-none">
                            <div class="mb-3">
                                <label for="set" class="form-label"><strong>Set:</strong></label>
                                <input type="number" name="set" class="form-control p-2" id="sets" placeholder="Number of Sets" aria-label="Request Name">
                                @error('set')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="rep" class="form-label"><strong>Repititions:</strong></label>
                                <input type="number" name="rep" class="form-control p-2" id="reps" placeholder="Number of Repititions" aria-label="Request Name">
                                @error('repetition')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label"><strong>Weights:</strong></label>
                                <input type="number" name="weight" class="form-control p-2" id="weights" placeholder="Weights (kg)" aria-label="Request Name">
                                @error('weight')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="allowSharing" style="font-size: 15px;">Allow Sharing &nbsp;
                                    <input type="hidden" name="allow_sharing" value="0">
                                    <input type="checkbox" name="allow_sharing" value="1" >
                                </label>
                            </div>
                        </div>
                        <div class="noWeightInput d-none">
                            <div class="mb-3">
                                <label for="weight" class="form-label"><strong>Duration:</strong></label>

                                <input type="number" name="duration" class="form-control p-2" id="duration" placeholder="Duration (mins)" aria-label="Request Name">
                                @error('duration')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="submit" id="habitbtn" class="btn midBtn redBtn">Use</button>
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
            text: "Do you want to save this workout plan to your workout habit?",
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
