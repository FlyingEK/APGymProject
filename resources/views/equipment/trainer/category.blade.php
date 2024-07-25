@extends('layouts.userLayout')
@section('content')
<div class="content container p-1">
    @livewire('search-equipment-machine',['category' => $category])

    <div class="page-title">{{ucfirst($category)}}</div>
    @forelse($equipment as $item)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$item->equipment->image)}}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$item->equipment->name}}   <span class="text-danger ">#{{$item->label}}</span></p>
                    @php
                        $color = $item->status == 'available'? 'success' : 'danger';
                        $color = $item->status == 'maintenance'? 'warning' : $color;
                    @endphp
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        {{ucfirst($item->status)}}
                    </div><br>
                    @if($item->status == 'available'|| $item->status == 'in use')
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                            Update Status
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    No equipment
    @endforelse


</div>


@endsection