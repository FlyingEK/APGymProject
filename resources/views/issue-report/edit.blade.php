@extends('layouts.userLayout')
@section('content')
<div class="container px-3 py-2 bg-white myShadow rounded" class="mt-3">
        <div class="form-title mb-4">Report Issue</div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="form-container">
                    <form id="issueEditForm" action={{route('issue-update',$issue->issue_id)}} class="issueForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="requestName" name="title" placeholder="Issue Title" aria-label="Request Name" value={{$issue->title}} >
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-select select2 p-2" id="issueType" name="type" aria-label="Issue Type">
                                <option value="gym" {{ $issue->type == "gym"? 'selected' : '' }}>Gym Issue</option>
                                <option value="equipment" {{ $issue->type == "equipment"? 'selected' : '' }}>Equipment Issue</option>
                                <option value="other" {{ $issue->type == "other" ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-control form-select  w-100" name="equipment_id" id="equipment-name">
                                <option value="" data-equip="" selected>Choose an equipment...</option>
                                @foreach($allEquipment as $equip)
                                    <option value="{{ $equip->equipment_id }}" data-equip="{{ $equip->equipment_id }}" {{ $issue->equipmentMachine->equipment->equipment_id  == $equip->equipment_id ? 'selected' : '' }}>{{ $equip->name }}</option>
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
                            <textarea class="form-control p-2" id="requestDescription" name="description" placeholder="Request Description" style="height: 100px;">{{$issue->description}}</textarea>
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
                                            <div id="imagePreview" style="background-image: url({{asset("storage/".$issue->image)}}');">
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
                                <button type="submit" class="btn midBtn redBtn">Update</button>
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
        var oldEquipmentMachineId = '{{ $issue->equipment_machine_id }}';

    function populateField() {
            var type = $('#issueType').val();
            var $equipmentSelect = $('#equipment-name');
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
            var equipmentId = $('#equipment-name').val();
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
        populateField()
        if(oldEquipmentMachineId){
            populateMachines()
        }
        $('#equipment-name').select2({
            placeholder: 'Select the equipment',
        });

        $('#equipment_machine').select2({
            placeholder: 'Select the equipment label',
        });

        $('#issueType').select2({
            placeholder: 'Select the issue type',
        });

        $('#issueType').on('change',populateField);

        $('#equipment-name').on('change', populateMachines);
    });
</script>
@stop
