<div >
    <div class="inter mt-1">
        <div class="pgtabs pgtab2 btn-group btn-group-sm" id="report-tab">
            {{-- <button type="button" wire:click="getWeeklyReport" class="btn text-white activeTab">Weekly</button>
            <button type="button" wire:click="getMonthlyReport"class="btn text-white ">Monthly</button>
            <button type="button" wire:click="getAnnualReport" class="btn text-white ">Annually</button> --}}
            <a href="#" class="btn text-white activeTab" onclick="fetchReport('weekly')">Weekly</a>
            <a href="#" class="btn text-white" onclick="fetchReport('monthly')">Monthly</a>
            <a href="#" class="btn text-white" onclick="fetchReport('annually')">Annually</a>
        </div>
    </div>

    <div class=" row mt-3">
        <div class="col-6">
            <div class="page-title" style="padding-right: 0px;">Workout Report</div>
        </div>
        {{-- <div class="col-6 d-flex  justify-content-end">
            <div class="report-filter">
                <a href="#">
                    <i class="material-symbols-outlined redIcon no-wrap">tune</i><span>  This Month</span>
                </a>
            </div>
        </div> --}}
    </div>

    <div class="card inter">
        <div class="card-body">
            <div class = "row align-items-center">
                <div class = "col-6 custom-padding">
                    <p class="report-label card-text">Days of working out:</p>
                </div>
                <div class = "col-6 no-padding">
                    <p class=" report-value card-text">&nbsp;{{ $totalDays }} day{{ $totalDays > 1 ? 's' : '' }}</p>
                </div>
            </div>
            <div class = "row align-items-center">
                <div class = "col-6 custom-padding">
                    <p class="report-label card-text">Total Workout Time:</p>
                </div>
                <div class = "col-6 no-padding">
                    <p class= "report-value card-text">&nbsp;{{ $totalTime }} hour{{ $totalTime > 1 ? 's' : '' }}</p>
                </div>
            </div>
            <div class = "row align-items-center" style="margin: 12px -15px;">
                <div class = "col-12 custom-padding">
                    <p class="report-label card-text">Most used equipment:</p>
                </div>
            </div>
            <div class=" row row-cols-3 row-cols-md-3 g-1">
                @foreach($mostUsedEquipment as $equipment)
                <div class="col">
                    <div class="equipmentCard card border-0 shadow-none">
                        <img src="{{ asset('storage/'.$equipment['image']) }}" class="equipmentCardImg card-img-top" alt="...">
                        <span class="card-text equipmentCardTxt text-center">{{ $equipment['duration'] }} hour{{ $equipment['duration']  > 1 ? 's' : '' }} </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
   
</div>
<script>
    function workoutReportData() {
        return {
            filter: 'weekly',
            totalDays: 0,
            totalTime: 0,
            mostUsedEquipment: [],
            get totalDaysText() {
                return `${this.totalDays} day${this.totalDays > 1 ? 's' : ''}`;
            },
            get totalTimeText() {
                return `${this.totalTime} hour${this.totalTime > 1 ? 's' : ''}`;
            },
            init() {
                this.fetchReport(this.filter);
            },
            fetchReport(filter) {
                this.filter = filter;
                fetch(`/fetch-report/${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        this.totalDays = data.totalDays;
                        this.totalTime = data.totalTime;
                        this.mostUsedEquipment = data.mostUsedEquipment;
                        this.updateEquipmentDisplay();
                    });
            },
            updateEquipmentDisplay() {
                const container = document.getElementById('most-used-equipment');
                container.innerHTML = '';
                this.mostUsedEquipment.forEach(equipment => {
                    const equipmentDiv = document.createElement('div');
                    equipmentDiv.classList.add('col');
                    equipmentDiv.innerHTML = `
                        <div class="equipmentCard card border-0 shadow-none">
                            <img src="/storage/${equipment.image}" class="equipmentCardImg card-img-top" alt="...">
                            <span class="card-text equipmentCardTxt text-center">${equipment.duration} hour${equipment.duration > 1 ? 's' : ''}</span>
                        </div>
                    `;
                    container.appendChild(equipmentDiv);
                });
            }
        };
    }
    function fetchReport(filter) {
        fetch(`/fetch-report/${filter}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-days').innerText = `${data.totalDays} day${data.totalDays > 1 ? 's' : ''}`;
                document.getElementById('total-time').innerText = `${data.totalTime} hour${data.totalTime > 1 ? 's' : ''}`;
                
                const mostUsedEquipmentContainer = document.getElementById('most-used-equipment');
                mostUsedEquipmentContainer.innerHTML = '';
                data.mostUsedEquipment.forEach(equipment => {
                    const equipmentDiv = document.createElement('div');
                    equipmentDiv.classList.add('col');
                    equipmentDiv.innerHTML = `
                        <div class="equipmentCard card border-0 shadow-none">
                            <img src="/storage/${equipment.image}" class="equipmentCardImg card-img-top" alt="...">
                            <span class="card-text equipmentCardTxt text-center">${equipment.duration} hour${equipment.duration > 1 ? 's' : ''}</span>
                        </div>
                    `;
                    mostUsedEquipmentContainer.appendChild(equipmentDiv);
                });
            });
    }
    </script>


