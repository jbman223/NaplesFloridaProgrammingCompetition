/**
 * Created by Jacob on 4/19/16.
 */
var socket = io.connect("http://159.203.168.143:8080/");

var repeater;

function updateTimeRemaining() {
    var thisthing = $(".time-remaining");
    var secondsLeft = thisthing.data("secondsremaining");
    thisthing.text(new Date(parseInt(secondsLeft) * 1000).toISOString().substr(11, 8));
    thisthing.data("secondsremaining", secondsLeft - 1);
    if (secondsLeft - 1 < 0) {
        clearInterval(repeater);
        loadInfo();
    }
}

function loadInfo() {
    $.get("/compete/api/currentCompetitionInfo.php", function (data) {
        console.log(data);
        if (data.error) {
            $(".competition-name").text("No Competition Currently");
            $(".section-name-footer").text("No Section Currently");
            $(".time-remaining").text("0").data("secondsremaining", 0);
            $(".footer").hide();

            setTimeout(function () {
                loadInfo();
            }, 1000 * 60 * 5);
        } else {
            $(".competition-name").text(data.current_competition_name);
            $(".section-name-footer").text(data.current_competition_section);
            $(".time-remaining").text(new Date(data.time_remaining * 1000).toISOString().substr(11, 8)).data("secondsremaining", data.time_remaining);
            updateTimeRemaining();
            repeater = setInterval(function () {
                updateTimeRemaining();
            }, 1000);
        }
    }, "json");
}

$(function () {
    $(".taunt").tooltip();
    loadInfo();
});


var lastTaunt = 0;

$(".taunt").click(function (e) {
    var thisTaunt = $(this);
    var tauntID = thisTaunt.data("tauntid");
    var senderID = $("input[name=team_name]").val();

    var d = new Date();
    var n = d.getTime();

    if (n > lastTaunt) {
        socket.emit("sendTaunt", {taunt_id: tauntID, sender_id: senderID})
        lastTaunt = n + 15 * 1000;
    }

});

var taunts = {
    "cry": '<img class="taunt" data-toggle="tooltip" title="Cry" data-tauntid="cry" src="http://programmingcompetition.org/compete/taunts/cry.gif" />',
    "smile": '<img class="taunt" data-toggle="tooltip" title="Smile" data-tauntid="smile" src="http://programmingcompetition.org/compete/taunts/smile.gif" />',
    "laugh": '<img class="taunt" data-toggle="tooltip" title="Smile" data-tauntid="smile" src="http://programmingcompetition.org/compete/taunts/laugh.gif" />',
    "rekt": '<img class="taunt" data-toggle="tooltip" title="#REKT" data-tauntid="rekt" src="http://programmingcompetition.org/compete/taunts/rekt.gif" />',
    "savage": '<img class="taunt" data-toggle="tooltip" title="Savage" data-tauntid="savage" src="http://programmingcompetition.org/compete/taunts/savage.gif" />',
    "typing": '<img class="taunt" data-toggle="tooltip" title="Typing" data-tauntid="typing" src="http://programmingcompetition.org/compete/taunts/typing.gif" />',
    "homer": '<img class="taunt" data-toggle="tooltip" title="Homer" data-tauntid="homer" src="http://programmingcompetition.org/compete/taunts/homer.gif" style="max-width:100%;" />'

};

socket.on("taunt", function (data) {
    console.log(data);
    if ($("." + data.sender_id)) {
        $("." + data.sender_id).popover({
            animation: true,
            content: taunts[data.taunt_id],
            html: true,
            placement: "auto",
            viewport: ".leaderboard",
            template: '<div class="popover" role="tooltip"><div class="popover-content"></div></div>'
        }).popover("show");
        var popped = $("." + data.sender_id);
        setTimeout(function () {
            popped.popover("destroy");
        }, 3500);

        var things = $(".taunt-box .taunted");
        if (things.length > 4)
            things[0].remove();

        $(".taunt-box").append('<div class="taunted col-md-2 text-center" style="overflow-x: hidden;border: white 1px solid;border-radius: 3px;padding:5px;margin: 10px;">' +
            '<h3 style="color:white;" class="fromID">' + data.sender_id + '</h3>' +
            '<div class="taunt-image">' +
            taunts[data.taunt_id] +
            '</div>' +
            '</div>');
    }
});

socket.on("newPost", function (data) {
    try {
        loadThreads();
    } catch (e) {

    }
});

socket.on("newReply", function (data) {
    try {
        if (data.thread_id == $("input[name=thread_id]").val())
            loadReplies();
    } catch (e) {

    }
});

socket.on("postRemoved", function (data) {
    try {
        if (data.thread_id == $("input[name=thread_id]").val()) {
            loadReplies();
        }
    } catch (e) {

    }
});

socket.on("play", function (data) {
    try {
        addVideo();
    } catch (e) {}
});

socket.on("threadRemoved", function (data) {
    try {
        console.log("removed");
        if (data.thread_id == $("input[name=thread_id]").val()) {
            window.location = "index.php";
        } else {
            loadThreads();
        }
    } catch (e) {

    }
});


socket.on("refresh", function (data) {
   if (data.official = true) {
       window.location.reload();
   }
});

socket.on("newSubmission", function (data) {
    try {
        loadNext();
    } catch (e) {

    }

    try {
        if (data.section_id) {
            loadLeaders(data.section_id);
        }
    } catch (e) {

    }

    try {
        if (data.section_id) {
            realoadScoreboard(data.section_id);
        }
    } catch (e) {

    }
});

socket.on("correctSubmission", function (data) {
    if (data.sound) {
        new Audio('http://programmingcompetition.org/compete/taunts/Audience_Applause-Matthiew11-1206899159.mp3').play()
    }
});