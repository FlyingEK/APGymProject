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
                    <form id="habitModal" action="" class="issueForm">
                        @csrf
                                                {{-- @method('POST') --}}

                        <input type="hidden" name="has_weight" id="has_weight" >
                        <div class="mb-3">
                            <input type="number" class="form-control p-2" id="reps" placeholder="Number of Repititions" aria-label="Request Name">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control p-2" id="sets" placeholder="Number of Sets" aria-label="Request Name">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control p-2" id="weights" placeholder="Weights (kg)" aria-label="Request Name">
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="allowSharing" style="   font-size: 15px;">Allow Sharing &nbsp;
                                <input type="checkbox" id="allowSharing" name="allowSharing" />
                            </label>
                        </div>

                        <div class="modal-footer">
                                <button type="submit" class="btn midBtn redBtn">Save</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
