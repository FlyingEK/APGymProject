@extends('layouts.trainerLayout')
@section('content')
<div class="page-title">Equipment that are used longer</div>

@for($i=0;$i<3;$i++)
<div class="card equipment shadow-sm mt-2 p-2">
    <div class="row">
        <div class="col-5 ">
                <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
        </div>
        <div class="col-7" style="padding-left: 5px">
            <div class=" mt-md-3 no-wrap">
                <p class="equipmentTitle">Equipment name</p>
                <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                    <i class="fas fa-helmet-safety"></i> 30 minutes
                </div><br>
                <a href="{{route('equipment-view')}}" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
@endfor
@endsection