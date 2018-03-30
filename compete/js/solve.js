/**
 * Created by Jacob on 4/11/16.
 */
$(function () {
    $("select[name=competition_section]").change();
});

function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
        .removeAttr('checked').removeAttr('selected');
}

$("select[name=competition_section]").change(function () {
    var selectedID = parseInt($(this).val());
    console.log(selectedID);

    $("select[name=problem_id]").children().each(function () {
        if (parseInt($(this).data("sectionid")) != selectedID) {
            $(this).hide();
        } else {
            $(this).prop('selected', true).show();
        }
    });

    if ($("select[name=problem_id]").find("option[data-sectionid="+selectedID+"]").length == 0) {
        $("select[name=problem_id]").append("<option value=\"-1\" selected=\"true\" data-sectionid=\""+selectedID+"\">No problems left to solve</option>");
    }
});

$(".problem").submit(function (e) {
    e.preventDefault();

    var messages = $(".messages");

    var problem = $("select[name=problem_id]").val();
    var section = $("select[name=competition_section]").val();
    var language = $("select[name=language]").val();
    // TODO: Change the implementation
    // var code = $("textarea[name=problem_code]").val();
    var code = window.ace.edit("editor").getValue();

    $(".submit").addClass("disabled");

    messages.append("<p>Started compiling code.</p>");
    $.post("../api/submitSolution.php", {code: code, problem_id: problem, section_id: section, language: language}, function (data) {
        $(".submit").removeClass("disabled");

        socket.emit("submitted", {section_id: section});

        if (data.error) {
            messages.append("<p class=\"text-danger\">"+data.error+"</p>");
        } else {
            resetForm($(".problem"));
            socket.emit("correctSubmission", {sound: true});
            messages.append("<p class=\"text-success\">"+data.success+"</p>");
            messages.append("<p class=\"text-danger\"><img src=\"http://programmingcompetition.org/compete/css/congratulations.gif\" style=\"max-width:100%;\" /></p>");
        }
    }, "json");

});

$("#competitor_view").click(function (e) {
    e.preventDefault();
    $(this).addClass("disabled");

    $.get("../api/competitorView.php", {id: $("select[name=problem_id]").val()}, function (data) {
        $(".code-area").html(data);
        $(".code-display").modal();
        $("#competitor_view").removeClass("disabled");
    }, "html");
});

$(".competitor-view").click(function (e) {
    e.preventDefault();
    $(this).addClass("disabled");

    $.get("../api/competitorView.php", {id: $(this).data("id")}, function (data) {
        $(".code-area").html(data);
        $(".code-display").modal();
        $("#competitor_view").removeClass("disabled");
    }, "html");
});
