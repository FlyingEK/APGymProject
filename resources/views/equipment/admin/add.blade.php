@extends('layouts.adminLayout')
@section('content')

<div class="pagetitle">
    <h1>Add Equipment</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('equipment-all') }}">Equipment</a></li>
            <li class="breadcrumb-item active">Add Equipment</li>
        </ol>
    </nav>
</div>

<div class="container rounded-2 shadow" style="background-color:white;position: relative;">
    <div class="pagetitle p-3">
        <h1>Equipment Details</h1>
    </div>
    <form action="{{ route('equipment.store') }}" method="POST" id="addEquipment" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" >
                    <label for="name">Equipment Name <span class="text-danger">*</span></label>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="description" value="{{ old('description') }}">
                    <label for="description">Description</label>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-6">
                <div class="form-group local-forms m-3">
                    <label for="has_weight">Has weight <span class="text-danger">*</span></label>
                    <div class="custom-select">
                        <select class="form-control form-select select" name="has_weight" >
                            <option selected>Choose...</option>
                            <option value="1" {{ old('has_weight') == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('has_weight') == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    @error('has_weight')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group local-forms m-3">
                    <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}">
                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-12">
                <div class="defect-upload m-3">
                    <div style="font-size:14px;">
                        Equipment Image  <span class="text-danger">*</span>
                    </div>
                    <div class="avatar-upload add-asset-upload">
                        <div class="avatar-edit">
                            <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" >
                             <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview" style="background-image: url();"></div>
                        </div>
                    </div>
                     @error('image')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                 </div> 
            </div>
        </div>
        <div class="pagetitle p-3">
            <h1>Equipment Tutorial</h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mx-3" style="font-size:14px;">
                    Tutorial Instructions
                </div>
                <div class="mt-1 mx-3">
                    <table class="w-100 mb-3" style="border:none;" id="dynamic_field">
                        @if(old('instruction'))
                        @foreach(old('instruction') as $index => $instruction)
                            <tr id="row{{ $index + 1 }}" class="my-2">
                                <td style="width:80%;"><input type="text" name="instruction[]" placeholder="Instruction {{ $index + 1 }}" class="form-control" value="{{ $instruction }}" /></td>
                                <td><button type="button" class="btn btn-danger btn_remove" id="{{ $index + 1 }}">X</button></td>
                            </tr>
                        @endforeach
                        @else
                            <tr id="row1" class="my-2">
                                <td style="width:80%;"><input type="text" name="instruction[]" placeholder="Instruction 1" class="form-control" /></td>
                                <td><button type="button" class="btn blueBtn" name="add" id="add">Add</button></td>
                            </tr>
                        @endif
                        @if ($errors->has('instruction'))
                            @foreach ($errors->get('instruction') as $error)
                                <tr>
                                    <td colspan="2" class="text-danger">{{ $error }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="urlAddress" value="{{ old('tutorial_youtube') }}">
                    <input type="hidden" name="tutorial_youtube" id="tutorial_youtube" value="{{ old('tutorial_youtube') }}">
                    <label for="tutorial_youtube">Tutorial Video Youtube Url</label>
                    @error('tutorial_youtube')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
                <div class="videoPreviewContainer mx-3"></div>
            </div>
         </div>
        <div class="row">
            <div class="col-lg-12 mt-3 mb-3 mr-4 text-end">
                <button class="btn redBtn" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
@include('equipment.admin.add-equipment-label-modal')
@endsection
@section('javascript')
    <script src="{{ asset('/js/video-preview.js') }}"></script>
    <script src="{{ asset('/js/img-preview.js') }}"></script>
    <script src="{{ asset('/js/dynamic-input-field.js') }}"></script>
    <script>
    // Add more instruction fields dynamically
    $(document).ready(function() {
        var oldLabels = {!! json_encode(old('labels', [])) !!};

        var i = {{ old('instruction') ? count(old('instruction')) : 1 }};
        var no = {{ old('instruction') ? count(old('instruction')) : 1 }};
        $("#add").click(function() {
            i++;
            no++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="instruction[]" placeholder="Instruction ' + no + '" class="form-control" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            no--;
            $('#row' + button_id + '').remove();
        });

        // Handle showing and populating the label modal
        $('#addEquipment').on('submit', function(e) {
            e.preventDefault();
            var quantity = $('input[name="quantity"]').val();
            if(quantity > 0 && quantity <= 10) {
            var labelInputs = '';
            for(var i = 0; i < quantity; i++) {
                    var oldValue = oldLabels[i] ? oldLabels[i] : '';
                labelInputs += '<div class="mb-3"><label for="label'+i+'" class="form-label">Equipment Machine ' + (i + 1) + ' Label <span class="text-danger">*</span></label><input type="text" class="form-control" id="label'+i+'" name="labels[]" value="'+oldValue+'"" required></div>';
            }
            $("#labelInputs").html(labelInputs);
            $('#equipmentLabelModal').modal('show');

            } else {
                alert("Please enter a valid quantity.\n The quantity should be not more than 10 and not less than 1.");
            }
        });

        $("#saveEquipmentLabels").click(function(){
            var allLabelsFilled = true;
            $("input[name='labels[]']").each(function() {
                if($(this).val().trim() === "") {
                    allLabelsFilled = false;
                    return false;
                }
            });

            if(!allLabelsFilled) {
                alert("Please fill all label fields");
                return;
            }

            // Now submit the form
            $("form")[0].submit();
        });

    });

    
    </script>
@endsection
