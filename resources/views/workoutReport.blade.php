<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Mobile-Optimized Webpage</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/styles.css" rel="stylesheet">
</head>


<body>
@include('partials.header')
<div class="content container p-1">
    <div class="">
        <div class="pgtabs btn-group btn-group-md">
            <a href="#" class="btn btn-primary " aria-current="page">Goals</a>
            <a href="#" class="btn btn-primary active">Reports</a>
            <a href="#" class="btn btn-primary">Leaderboard</a>
        </div>
    </div>

    <div class=" mt-3">
        <div class="pgtabs btn-group btn-group-sm" id="report-tab">
            <a href="#" class="btn btn-primary active" aria-current="page">Daily</a>
            <a href="#" class="btn btn-primary">Monthly</a>
            <a href="#" class="btn btn-primary">Annually</a>
        </div>
    </div>

    <div class="report-filter mt-2">
        <a href="#">
            <i class="material-symbols-outlined redIcon">tune</i><span>  This month</span>
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class = "row align-items-center">
                <div class = "col-7 custom-padding">
                    <p class="report-label card-text">Days of working out:</p>
                </div>
                <div class = "col-5 no-padding">
                    <p class=" report-value card-text">15 days</p>
                </div>
            </div>
            <div class = "row align-items-center">
                <div class = "col-7 custom-padding">
                    <p class="report-label card-text">Total Workout Time:</p>
                </div>
                <div class = "col-5 no-padding">
                    <p class= "report-value card-text">35 hours</p>
                </div>
            </div>
            <div class = "row align-items-center">
                <div class = "col-12 custom-padding">
                    <p class="report-label card-text">Most used equipment:</p>
                </div>
            </div>

        </div>
    </div>
</div>
@include('partials.bottomnav-user')
</body>


