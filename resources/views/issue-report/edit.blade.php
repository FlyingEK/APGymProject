@extends('layouts.userLayout')
@section('content')
<div class="container px-3 py-2 bg-white my-shadow rounded" class="mt-3">
        <div class="form-title mb-4">Report Issue</div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="form-container">
                    <form id="issueEditForm" class="issueForm">
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="requestName" placeholder="Request Name" aria-label="Request Name">
                        </div>
                        <div class="mb-3">
                            <div class="custom-select">
                                <select class="form-select p-2" id="issueType" aria-label="Issue Type">
                                    <option selected>Select Type</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control p-2" id="requestDescription" placeholder="Request Description" style="height: 100px;" aria-label="Request Description"></textarea>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-12">
                                <div class="image-upload">
                                    <div class="p-2 imgLabel">
                                        Attach Image
                                    </div>
                                    <div class="avatar-upload add-img-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="issueImage" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url();">
                                            </div>
                                        </div>
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

@stop