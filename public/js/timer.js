var totalSecs = 0;
var timerInterval;
var holdTimeout;
var holdDuration = 3000; // 3 seconds to hold
var setNo = 1;
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
    var holdTextInterval;
    $('.turnEquipment').removeClass('d-none');

    $(".start").click(function() {
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
                    $('#ongoingWorkout').removeClass('d-none');
                    $("#workoutStatus").html('Working Out');
                    $("#setNo").html("Set "+setNo);
                    $('.turnEquipment').addClass('d-none');
                    timerInterval = setInterval(incTimer, 1000);
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
            $("#timer").text("00:00:00");
            button.html('<span class="material-symbols-outlined">stop</span>');
            Swal.fire({
                title: "Workout Completed!",
                text: "You are stronger than you think.",
                imageUrl: '/img/tada.png',
                imageWidth: 60,
                imageHeight: 60,
                imageAlt: "Tada"
              });
              $('#ongoingWorkout').addClass('d-none');
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
