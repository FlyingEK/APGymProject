

var totalSecs = 0;
var timerInterval;
var holdTimeout;
var holdDuration = 3000; // 3 seconds to hold
var setNo = 0;
let isTimerRunning = false;

function incTimer() {
    totalSecs++;
    var currentHours = Math.floor(totalSecs / 3600);
    var currentMinutes = Math.floor((totalSecs % 3600) / 60);
    var currentSeconds = totalSecs % 60;

    if(currentSeconds < 10) currentSeconds = "0" + currentSeconds;
    if(currentMinutes < 10) currentMinutes = "0" + currentMinutes;
    if(currentHours < 10) currentHours = "0" + currentHours;

    $("#timer").text(currentHours + ":" + currentMinutes + ":" + currentSeconds);
}

$(document).ready(function() {
    // Attach the beforeunload event to the window
    window.addEventListener('beforeunload', function (e) {
        // If the timer is running, show the confirmation dialog
        if(isTimerRunning){
            e.preventDefault();
            e.returnValue = ''; // Modern browsers require returnValue to be set
            return 'Are you sure you want to leave? Your workout timer will be reset.';
        }

    });

    var holdTextInterval;
    // $('.turnEquipment').removeClass('d-none');

    $(".start").click(function() {
        var workoutQueueId = $(this).data('id');

        if (!timerInterval) {
            Swal.fire({
                title: "Start workout?",
                html: "<p>Please proceed to the treadmill labeled <strong style='color: red;'>#TR02</strong>.</p>",
                imageUrl: '/img/workoutIcon.png',
                imageWidth:70,
                imageHeight: 70,
                imageAlt: "dumbbell",
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn blueBtn',
                    cancelButton: 'btn redBtn'
                },
                confirmButtonText: "Yes",
                cancelButtonText: "I don't want to use it",
            }).then((result) => {
                if (result.isConfirmed) {
                    isTimerRunning=true;

                // Send a POST request to start the workout
                $.ajax({
                    url: workoutStartRoute, // Adjust the route name as necessary
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), 
                        workoutId: workoutQueueId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Handle the success response
                            Swal.fire({
                                title: "Workout started!",
                                text: "Enjoy your workout!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                // Redirect to the workout index page after the alert is closed
                                window.location.href = workoutIndex ; // Adjust the route name as necessary
                            });
                        } else {
                            // Handle the error response
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        Swal.fire({
                            title: "Error!",
                            text: "An error occurred while starting the workout.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
                    // $('#ongoingWorkout').removeClass('d-none');
                    // $("#workoutStatus").html('Working Out');
                    // $("#setNo").html("Set "+setNo);
                    // $('.turnEquipment').addClass('d-none');
                    //timerInterval = setInterval(incTimer, 1000);
                }else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "If you cancel, this equipment will be available for others to use.",
                        icon: "warning",
                        showCancelButton: true,
                        customClass: {
                            confirmButton: 'btn blueBtn',
                            cancelButton: 'btn redBtn'
                        },
                        confirmButtonText: "Yes, release it!",
                        cancelButtonText: "No, keep it reserved",
                      }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Released!',
                                'The equipment is now available for others.',
                                'success'
                            );
                        }
                      });
                  }
            });
        }
    });

    $("#pause").click(function () {
        if (timerInterval) {
            Swal.fire({
                title: "Finish this set?",
                text: "The timer will be paused and you can rest for a while before another set.",
                imageUrl: '/img/workoutIcon.png',
                imageWidth: 70,
                imageHeight: 70,
                imageAlt: "dumbbell",
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn blueBtn',
                    cancelButton: 'btn redBtn'
                },
                confirmButtonText: "Yes",
                cancelButtonText: "Not yet",
              }).then((result) => {
                if (result.isConfirmed) {
                    clearInterval(timerInterval);
                    timerInterval = null;
                    $("#pauseIcon").html('<span class="material-symbols-outlined">play_arrow</span>');
                    $("#pauseText").html("Resume");
                    $("#workoutStatus").html('Resting');
                }
              });
        } else {
              setNo++;
              timerInterval = setInterval(incTimer, 1000);
              $("#setNo").html("Set "+setNo);
              $("#pauseIcon").html('<span class="material-symbols-outlined">pause</span>');
              $("#pauseText").html("Rest");
              $("#workoutStatus").html('Working Out');
        }
    });

    function startHold(button) {
        var countdown = holdDuration / 1000;

        holdTimeout = setTimeout(function() {
            clearInterval(timerInterval);
            timerInterval = null;
            totalSecs = 0;
            isTimerRunning = false;
             // Get the timer text and transform it to minutes
            var timerText = $("#timer").text();
            var timeParts = timerText.split(":");
            var hours = parseInt(timeParts[0], 10);
            var minutes = parseInt(timeParts[1], 10);
            var seconds = parseInt(timeParts[2], 10);
            var totalMinutes = (hours * 60) + minutes + Math.floor(seconds / 60);

            $("#timer").text("00:00:00");
            $('#modalSet').val(setNo); // Example value for set
            $('#modalDuration').val(totalMinutes); // Example value for duration
            $('#endWorkout').modal('toggle');
            button.html('<span class="material-symbols-outlined">stop</span>');
            //   $('#ongoingWorkout').addClass('d-none');
        }, holdDuration);

        holdTextInterval = setInterval(function() {
            if (countdown > 0) {
                button.text(countdown + "s");
                countdown--;
            } else {
                clearInterval(holdTextInterval);
            }
        }, 1000);
    }

    function endHold(button) {
        clearTimeout(holdTimeout);
        clearInterval(holdTextInterval);
        button.html('<span class="material-symbols-outlined">stop</span>');
    }

    $("#holdToEnd").on("mousedown touchstart", function() {
        startHold($(this));
    }).on("mouseup touchend touchcancel mouseleave", function() {
        endHold($(this));
    });
});
