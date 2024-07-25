<div class="mb-3">
    <div class="input-group mt-2 searchBox mb-2">
        <input type="text"  wire:model="searchTerm1" wire:keyup="updateSearch" class="form-control rounded border-0" placeholder="Search" />
    </div>
    @if ($searchTerm1)
    @forelse ($equipments as $equipment)

    <div class="card equipment shadow-sm mt-2 p-2">
        <div class="row">
            <div class="col-5 ">
                    <img class="img-fluid equipmentImg" style="height: 100px;" src="{{ asset('storage/'.$equipment->equipment->image)}}" alt="Work Order Image" ><br/>
            </div>
            <div class="col-7" style="padding-left: 5px">
                <div class=" mt-md-3 no-wrap">
                    <p class="equipmentTitle">{{ $equipment->equipment->name }}   &nbsp;<span class="text-danger ">{{$equipment->label}}</span></p>
                    @php
                    $color = $equipment->status == 'available'? 'success' : 'danger';
                    $color = $equipment->status == 'maintenance'? 'warning' : $color;
                    @endphp
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-{{$color}} shadow-none">
                        {{ucfirst($equipment->status)}}
                    </div><br>
                    @if($equipment->status == 'available'|| $equipment->status == 'in use')
                    <form id="updateStatus{{$equipment->equipment_machine_id}}" action = {{route('equipment-status-update', $equipment->equipment_machine_id)}} method="POST">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <button type="button" onclick="confirmUpdateStatus('updateStatus{{$equipment->equipment_machine_id}}')" class="myBtn btnFront btn btn-primary redBtn shadow-none">
                                Update Status
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <li class="list-group-item">No equipment found.</li>
    @endforelse
    @endif
</div>
