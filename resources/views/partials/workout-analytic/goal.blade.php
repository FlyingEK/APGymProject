<div class="goalCard card">
    <div class="inter">
        <div class="d-flex justify-content-center">
            <svg
                width="250" height="250" viewBox="0 0 250 250"
                class="circular-progress" style="--progress: 50">
                <circle class="bg"></circle>
                <circle class="fg"></circle>
                <text x="50%" y="35%" class="progress-label">Workout Time</text>
                <text x="50%" y="50%" class="progress-value" id="progress-value" >11 hour</text>
                <text x="50%" y="63%"  class="progress-subtext">of 30 hours</text>
            </svg>
        </div>

        <div class="container mt-5">
            <div class="progress-container d-flex align-items-center ">
                <div class="progress-text flex-grow-1">Lat pull down: 40kg</div>
                <span class="redIcon material-symbols-outlined ms-2">
                    flag
                </span>
            </div>
            <div class="progress mb-3">
                <div class="progress-bar bg-success d-flex align-items-center justify-content-center" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div>10kg</div>
                </div>
            </div>
        
            <div class="progress-container d-flex align-items-center ">
                <div class="progress-text flex-grow-1">Leg press: 50kg</div>
                <span class="redIcon material-symbols-outlined ms-2">
                    flag
                </span>
            </div>
            <div class="progress mb-3">
                <div class="progress-bar bg-info d-flex align-items-center justify-content-center" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                    <div>40kg</div>
                </div>
            </div>
        </div>
        

        <div class="mt-4 mb-3 d-flex justify-content-end">
            <a href={{route('set-goal')}} class="myBtn btnFront btn btn-primary redBtn shadow-none"  style="padding: 10px;">
                Set Goal
            </a>
        </div>


    </div>
</div>