<div class="mb-3">
    <div class="input-group mt-2 searchBox mb-2">
        <input type="text"  wire:model="searchTerm" wire:keyup="updateSearch" class="form-control rounded border-0" placeholder="Search" />
    </div>
    @if ($searchTerm)
    @forelse ($equipments as $equipment)

    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('/img/treadmill.jpg') }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{ $equipment->name }}</p>
                    @php
                    $color = $equipment->status == 'Available'? 'success' : 'danger';
                    @endphp
                    @if($equipment->status == 'Available')
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                    Available: {{ $equipment->available_machines_count }}
                    </div><br>
                    @else
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        {{$equipment->status}}
                    </div><br>
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        {{$equipment->statusDetail['currentPersonInQueue']}} in queue
                    </div>
                    <div class = "myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        Estimated wait time: {{$equipment->statusDetail['totalEstimatedTime']}} mins
                    </div>
                    @endif
                    <a href="{{route('equipment-view',$equipment->equipment_id)}}" class="stretched-link"></a>
                    @if ($isCheckIn)
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-id="{{$equipment->equipment_id}}" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                            {{$equipment->status == 'Available'? 'Use' : 'Queue'}}
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse

    @forelse($allowSharing as $item)
    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$item->image) }}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{$item->name}} #{{$item->equipment_machine_id}}</p>
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-danger shadow-none">
                        In Use
                        </div>
                        <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                        Allow Sharing
                        </div><br>
                    <a href="{{route('equipment-view', $item->equipment_id)}}" class="stretched-link"></a>
                    @if($isCheckIn)
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-machineid="{{$item->equipment_machine_id}}" data-id="{{$item->equipment_id}}" data-share="1" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                            Use
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse
    @if ($equipments->isEmpty() && $allowSharing->isEmpty())
    <li class="list-group-item">No equipment found.</li>

    </div>
    @endif
    @endif
</div>
