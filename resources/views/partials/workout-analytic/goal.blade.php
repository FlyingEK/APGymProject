<div class="goalCard card">
    <div class="inter">
    @if(!$overallGoal && !$strengthGoals->count() && !$completedStrengthGoals->count())
    <p> No goal set yet. Click the add button to add new goals now.</p>
    @endif
    @if($overallGoal)
    <div class="d-flex justify-content-start page-title mb-3" >
        <p></p>
    </div>
        <div class="d-flex justify-content-center">
            <svg
                width="250" height="250" viewBox="0 0 250 250"
                class="circular-progress" style="--progress: 50">
                <circle class="bg"></circle>
                <circle class="fg"></circle>
                <text x="50%" y="35%" class="progress-label">Workout Time</text>
                <text x="50%" y="50%" class="progress-value" id="progress-value" >{{$overallGoal->progress}}  hour{{$overallGoal->progress>1?'s':''}} </text>
                <text x="50%" y="63%"  class="progress-subtext">of {{$overallGoal->workout_hour}} hour{{$overallGoal->workout_hour>1?'s':''}}</text>
            </svg>
            <br>
        </div>
        <div class="progress-text mt-2 d-flex justify-content-center">
            <p class="">Before: &nbsp; </p> <p class="progress-subtext"> {{$overallGoal->target_date->format('F j, Y')}}</p> </div>

        @endif
        <div class="container mt-5">
            @forelse($strengthGoals as $goal)
            @php
                $progressPercent = min(100, round(($goal->progress / $goal->weight) * 100));
            @endphp
            <div class="progress-container d-flex align-items-center ">
                <div class="progress-text flex-grow-1">{{$goal->equipment->name}}: {{$goal->weight}}kg</div>
                <span class="redIcon material-symbols-outlined ms-2">
                    flag
                </span>
            </div>
            <div class="progress mb-3">
                <div class="progress-bar bg-success d-flex align-items-center justify-content-center" role="progressbar" style="width: {{$progressPercent}}%;" aria-valuenow="{{$progressPercent}}" aria-valuemin="0" aria-valuemax="100">
                    <div>{{$goal->progress}}kg</div>
                </div>
            </div>
            @empty
            @endforelse

            @forelse($completedStrengthGoals as $goal)
            @php
                $progressPercent = round($goal->progress/$goal->weight)*100 > 100 ? 100 : round($goal->progress/$goal->weight)*100;
            @endphp
            <div class="progress-container d-flex align-items-center ">
                <div class="progress-text flex-grow-1">{{$goal->equipment->name}}: {{$goal->weight}}kg</div>
                <span class="redIcon material-symbols-outlined ms-2">
                    flag
                </span>
            </div>
            <div class="progress mb-3">
                <div class="progress-bar bg-success d-flex align-items-center justify-content-center" role="progressbar" style="width: {{$progressPercent}}%;" aria-valuenow="{{$progressPercent}}" aria-valuemin="0" aria-valuemax="100">
                    <div>{{$goal->progress}}</div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        

        <div class="mt-4 mb-3 d-flex justify-content-end">
            <a href={{route('set-goal')}} class="myBtn btnFront btn btn-primary redBtn shadow-none"  style="padding: 10px;">
                Set Goal
            </a>
        </div>


    </div>
</div>
<script>
@if($overallGoal)
const progressPercent = {{ round($overallGoal->progress / $overallGoal->workout_hour * 100) }} > 100 ? 100 : {{ round($overallGoal->progress / $overallGoal->workout_hour * 100) }};
console.log(progressPercent);
    function setProgress(element, progress) {
    const radius = element.querySelector('.fg').r.baseVal.value;
    const circumference = radius * 2 * Math.PI;
    const offset = circumference - progress / 100 * circumference;

    element.style.setProperty('--progress', progress);
    element.querySelector('.fg').style.strokeDashoffset = offset;
    element.querySelector('#progress-value').textContent = `${Math.round(progress / 100 * 30)} hours`; 
}

const circularProgress = document.querySelector('.circular-progress');
setProgress(circularProgress,progressPercent);

@endif
</script>