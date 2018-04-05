/**
 * Created by Jacob on 3/3/16.
 */
$(".add-section").submit(function (e) {
    e.preventDefault();

    var section_name = $(this).find("input[name=section_name]").val();
    var start = $(this).find("input[name=start]").val();
    var end = $(this).find("input[name=end]").val();
    var competitionID = $(this).find("input[name=competition_id]").val();
    console.log({section_name: section_name, start: start, end: end, competition_id: competitionID});
    $.post("../../api/admin/competition/addSection.php", {
        section_name: section_name,
        start: start,
        end: end,
        competition_id: competitionID
    }, function (data) {
        if (data.error) {
            $(this).parent().find("alert").text(data.error).show();
        } else {
            window.location.reload();
        }
    });
});

$(".refresh").click(function (e) {
    e.preventDefault();
    socket.emit("sendRefresh", {d: true});
});

$(".play").click(function (e) {
    e.preventDefault();
    socket.emit("sendPlay", {d: true});
});

$(".add-problem").submit(function (e) {
    e.preventDefault();

    var section_id = $(this).find("select[name=section_id]").val();
    var problem_id = $(this).find("select[name=problem_id]").val();
    $.post("../../api/admin/competition/addProblem.php", {
        section_id: section_id,
        problem_id: problem_id
    }, function (data) {
        if (data.error) {
            $(this).parent().find("alert").text(data.error).show();
        } else {
            window.location.reload();
        }
    }, "json");
});

$(".add-quiz").submit(function (e) {
    e.preventDefault();

    var section_id = $(this).find("select[name=section_id]").val();
    var quiz_id = $(this).find("select[name=quiz_id]").val();
    $.post("../../api/admin/competition/addQuiz.php", {
        section_id: section_id,
        quiz_id: quiz_id
    }, function (data) {
        if (data.error) {
            $(this).parent().find("alert").text(data.error).show();
        } else {
            window.location.reload();
        }
    }, "json");
});

$(".rescore").click(function (e) {
    e.preventDefault();
    var clicked = $(this);
    clicked.addClass("disabled");
    var problemID = $(this).data("problemid");
    var sectionID = $(this).data("sectionid");
    $.post("../../api/admin/competition/rescoreProblem.php", {problem_id: problemID, section_id: sectionID}, function (data) {
        clicked.removeClass("disabled");
        console.log(data);
    });
});


var editing = false;

$(".edit-button").click(function (e) {
    e.preventDefault();
    var row = $(this).parent().parent();

    console.log(editing);

    if (editing) {
        editing = false;

        var section_name = row.find(".edit-section-name").val();
        var section_start = row.find(".edit-section-start").val();
        var section_end = row.find(".edit-section-end").val();
        var section_id = row.data("sectionid");
        var competition_id = $("input[name=competition_id]").val();

        console.log({
            section_name: section_name,
            start: section_start,
            end: section_end,
            section_id: section_id
        });

        $.post("../../api/admin/competition/addSection.php", {
            section_name: section_name,
            start: section_start,
            end: section_end,
            section_id: section_id,
            competition_id: competition_id
        }, function (data) {
            window.location.reload();
            console.log(data);
        }, "json");



        $(this).text("Edit");
    } else {
        editing = true;

        var section_name = row.find(".section-name");
        var section_start = row.find(".section-start");
        var section_end = row.find(".section-end");

        section_name.html("<input class='form-control edit-section-name' type='text' value='" + section_name.text() + "' />");
        section_start.html("<input class='form-control edit-section-start' type='text' value='" + section_start.text() + "' />");
        section_end.html("<input class='form-control edit-section-end' type='text' value='" + section_end.text() + "' />");


        $(this).text("Save");
    }


});
