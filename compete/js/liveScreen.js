/**
 * Created by Jacob on 4/20/16.
 */
$(function () {
   loadLeaders($("input[name=section_id]").val());
});

function addVideo() {
    $("body").append('<iframe style="width:100%;height:100%;z-index:1000;position:absolute;top:0;left:0;" src="https://www.youtube.com/embed/EJwwSlT_-Ag?autoplay=1&controls=0&modestbranding=1&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>')
}

function loadLeaders(sectionID) {
    $.post("../../api/scoreboard/leaderboardJSON.php", {id: sectionID}, function (data) {
        console.log(data);
        if (data.error) {
            console.log(data);
        } else {
            $(".leaderboard").html("");

            var sortable = [];
            for (var vehicle in data)
                sortable.push([vehicle, data[vehicle]])

            if (sortable[0][1] == 0) {
                $(".leaderboard").html("<h1>No section in progress.</h1>");
                return;
            }

            sortable.sort(function(a, b) {return a[1] - b[1]});
            var i = 1;

            console.log(sortable);
            $.each(sortable, function (key, value) {
                if (i==6) {
                    return;
                }
                $(".leaderboard").append("<h"+i+" class=\""+value[0].replace(" ", "")+"\">"+value[0]+"</h"+i+">");
                i++;
            });
        }
    }, "json");
}