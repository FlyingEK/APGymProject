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
    <form>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="" required>
                    <label for="floatingInput">Equipment Name <span class="text-danger">*</span></label>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="" >
                    <label for="floatingInput">Description</label>
                </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-6">
                <div class="form-group local-forms m-3">
                    <label for="formSelect">Has weight <span class="text-danger">*</span></label>
                    <div class="custom-select">
                        <select class="form-control form-select select" id="formSelect" placeholder="" required>
                            <option value="">Choose...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group local-forms m-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="" >
                    <label for="floatingInput">Quantity</label>
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
                            <input asp-for="Image" type='file' name="Image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                             <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview" style="background-image: url();">
                            </div>
                        </div>
                    </div>
                     <span asp-validation-for="Image" class="text-danger" style="padding-left: 5px;"></span>
                 </div> 
            </div>
        </div>
        <div class="pagetitle p-3">
            <h1>Equipment Tutorial</h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mx-3" style="font-size:14px;">
                    Tutorial Instructions <span class="text-danger">*</span>
                </div>
                <div class="mt-1 mx-3">
                    <table class="w-100 mb-3" style="border:none;" id="dynamic_field">
                        <tr class="my-2">
                            <td style="width:80%;"><input type="text" name="instruction[]" placeholder="Instruction 1" class="form-control" /></td>
                            <td><button type="button" class="btn blueBtn" name="add" id="add">Add</button></td>  
                        </tr>
                    </table>
                </div>

                </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group local-forms m-3">
                    <input type="text" class="form-control" name="urlAddress" id="floatingInput" placeholder="" >
                    <label for="floatingInput">Tutorial Video Youtube Url</label>
                </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
                <div class="videoPreviewContainer mx-3">
                </div>
            </div>
         </div>
        <div class="row">
            <div class="col-lg-12 mt-3 mb-3 mr-4 text-end">
                <button class="btn redBtn" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection
@section('javascript')
    <script src="{{ asset('/js/video-preview.js') }}"></script>
    <script src="{{ asset('/js/img-preview.js') }}"></script>
    <script src="{{ asset('/js/dynamic-input-field.js') }}"></script>
@endsection


