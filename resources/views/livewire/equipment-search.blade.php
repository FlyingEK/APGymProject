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
                    <div class="myBtn btn m-2 equipmentTag btn-sm btn-outline-success shadow-none">
                        <i class="fa-solid fa-helmet-safety"></i> Available
                    </div><br>
                    <a href="{{route('equipment-view',$equipment->equipment_id)}}" class="stretched-link"></a>
                    @if ($isCheckIn)
                    <div class="d-flex justify-content-end">
                        <button type="button" class="myBtn btnFront btn btn-primary redBtn shadow-none" data-bs-toggle="modal" data-bs-target="#viewEquipmentHabit">
                            Use
                        </button>
                    </div>
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
