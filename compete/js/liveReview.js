/**
 * Created by Jacob on 4/17/16.
 */

$(function () {
    console.log("testing");
    loadNext();
});

function loadNext() {
    console.log("testing");
    $.get("../../api/admin/competition/live/loadNext.php", {competition_id: $(".review-container").data("competitionid")}, function (data) {
        console.log(data);
        $(".review-container").html(data);
        $('pre code').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    }, "html");
}

$(".review-container").on("click", ".switch", function (e) {
    e.preventDefault();
    $.post("../../api/admin/competition/switchDecision.php", {solved_problem_id: $(this).data("solvedproblemid")}, function (data) {
        if (data.success) {
            loadNext();
        } else {
            console.log(data);
        }
    }, "json");
});

$(".review-container").on("click", ".approve", function (e) {
    e.preventDefault();
    $.post("../../api/admin/competition/approveProblem.php", {solved_problem_id: $(this).data("solvedproblemid")}, function (data) {
        if (data.success) {
            loadNext();
        } else {
            console.log(data);
        }
    }, "json");
});