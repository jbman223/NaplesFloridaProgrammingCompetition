/**
 * Created by Jacob on 4/18/16.
 */
function realoadScoreboard(sectionID) {
    $.get("../api/scoreboard/leaderboardOutput.php", {id: sectionID}, function (data) {
        $(".leaderboard[data-sectionid="+sectionID+"]").html(data);
    }, "html");
}

$(".leaderboard").each(function () {
    var sectionID = $(this).data("sectionid");
    var tabPane = $(this);
    $.get("../api/scoreboard/leaderboardOutput.php", {id: sectionID}, function (data) {
        tabPane.html(data);
    }, "html");
});