var totalSecs = 0;
var timerInterval;
var holdTimeout;
var holdDuration = 3000; // 3 seconds to hold

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

    $("#start").click(function() {
        if (!timerInterval) {
            timerInterval = setInterval(incTimer, 1000);
        }
    });

    $("#pause").click(function() {
        clearInterval(timerInterval);
        timerInterval = null;
    });

    function startHold(button) {
        var countdown = holdDuration / 1000;

        holdTimeout = setTimeout(function() {
            clearInterval(timerInterval);
            timerInterval = null;
            totalSecs = 0;
            $("#timer").text("00:00:00");
            button.html('<span class="material-symbols-outlined">stop</span>');
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
