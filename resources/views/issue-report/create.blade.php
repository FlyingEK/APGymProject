@extends('layouts.userLayout')
@section('content')
<div class="container px-3 py-2 bg-white myShadow rounded" class="mt-3">
        <div class="form-title mb-4">Report Issue</div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="form-container">
                    <form id="issueAddForm" action={{route('issue-store')}} class="issueForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="requestName" name="title" placeholder="Issue Title" aria-label="Request Name" value="{{old('title')}}" >
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-select p-2" id="issueType" name="type" aria-label="Issue Type">
                                <option value="gym" {{ old('type') == "gym"? 'selected' : '' }}>Gym Issue</option>
                                <option value="equipment" {{ old('type') == "equipment"? 'selected' : '' }}>Equipment Issue</option>
                                <option value="other" {{ old('type') == "other" ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-control form-select  w-100" name="equipment_id" id="equipment-name4">
                                <option value="" data-equip="" selected>Choose an equipment...</option>
                                @foreach($allEquipment as $equip)
                                    <option value="{{ $equip->equipment_id }}" data-equip="{{ $equip->equipment_id }}" {{ old('equipment_id') == $equip->equipment_id ? 'selected' : '' }}>{{ $equip->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-control form-select mb-3 w-100" name="equipment_machine_id" id="equipment_machine">
                            </select>
                            @error('equipment_machine_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control p-2" id="requestDescription" name="description" placeholder="Request Description" style="height: 100px;">{{old('description')}}</textarea>
                        </div>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="row mb-1">
                            <div class="col-lg-12">
                                <div class="image-upload">
                                    <div class="p-2 imgLabel">
                                        Attach Image
                                    </div>
                                    <div class="avatar-upload add-img-upload">
                                        <div class="avatar-edit">
                                            <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" >
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url();">
                                            </div>
                                        </div>
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                 </div> 
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn midBtn redBtn">Submit</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
@section('javascript')
    <script src="{{ asset('/js/img-preview.js') }}"></script>
    <script src="{{ asset('js/custom-select-box.js') }}"></script>
    <script>
        
    $(document).ready(function() {
        var oldEquipmentMachineId = '{{ old("equipment_machine_id") }}';

    function populateField() {
        console.log('getting name');

            var type = $('#issueType').val();
            var $equipmentSelect = $('#equipment-name4');
            var $machineSelect = $('#equipment_machine');

            if (type == 'equipment') {
                $equipmentSelect.prop("disabled", false);
                $machineSelect.prop("disabled", false);
            } else {
                $equipmentSelect.prop("disabled", true);
                $machineSelect.prop("disabled", true);
            }
        }
        function populateMachines() {
            console.log('getting machines');

            var equipmentId = $('#equipment-name4').val();
            var $machineSelect = $('#equipment_machine');
            $machineSelect.empty();
            $machineSelect.append('<option value="" selected>Choose an equipment label...</option>');
            console.log(equipmentId);
            if (equipmentId) {
                $.ajax({
                    url: '{{ route("get-equipment-machines") }}',
                    type: 'GET',
                    data: { equipment_id: equipmentId },
                    success: function(data) {
                        console.log(data);

                        $.each(data, function(index, machine) {
                            $machineSelect.append('<option value="'+ machine.equipment_machine_id +'" '+ (oldEquipmentMachineId == machine.equipment_machine_id ? 'selected' : '') +'>'+ machine.label +'</option>');
                        });
                        $machineSelect.trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
        populateField();
        if(oldEquipmentMachineId){
            clearTimeout(this.populateTimeout);
            this.populateTimeout = setTimeout(populateMachines, 300);
        }
        $('#equipment-name4').select2({
            placeholder: 'Select the equipment',
        });

        $('#equipment_machine').select2({
            placeholder: 'Select the equipment label',
        });

        $('#issueType').select2({
            placeholder: 'Select the issue type',
        });

        $('#issueType').on('change',populateField);

        $('#equipment-name4').on('change', function(){
            clearTimeout(this.populateTimeout);
            this.populateTimeout = setTimeout(populateMachines, 300);
        });
    });
</script>
@endsection
