/**
 * Created by Jacob on 4/11/16.
 */
$(function () {
    $("select[name=competition_section]").change();
    $("select[name=clarification_type]").change();
    loadThreads();
    loadReplies();
});

function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
        .removeAttr('checked').removeAttr('selected');
}

function loadThreads() {
    $.get("../api/forum/loadPosts.php", function (data) {
        $(".threads").html(data);
        jQuery("time.timeago").timeago();
    }, "html");
}

function loadReplies() {
    var threadID = $("input[name=thread_id]").val();

    $.get("../api/forum/loadReplies.php", {id: threadID}, function (data) {
        $(".replies").html(data);
        jQuery("time.timeago").timeago();
    }, "html");
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

$("select[name=clarification_type]").change(function () {
    var selectedType = $(this).val();
    if (selectedType === "Question Error") {
        $(".hidden-non-question").show();
        $(".hidden-question").hide();
    } else {
        $(".hidden-non-question").hide();
        $(".hidden-question").show();

    }
});

$(".problem").submit(function (e) {
    e.preventDefault();


    var type = $("select[name=clarification_type]").val();
    var section = $("select[name=competition_section]").val();
    var problem = $("select[name=problem_id]").val();
    var message = $("textarea[name=message]").val();
    var title = $("input[name=clarification_title]").val();

    $(".submit").addClass("disabled");

    var inputs = {type: type, problem_id: problem, section_id: section, message: message, title: title};
    console.log(inputs);

    $.post("../api/forum/newThread.php", inputs, function (data) {
        $(".submit").removeClass("disabled");

        if (data.error) {
            console.log(data.error);
        } else {
            console.log(data.success);
            resetForm($(".problem"));
            socket.emit("post", {"success": true});
        }
    }, "json");

});

$(".reply").submit(function (e) {
    e.preventDefault();

    var message = $("textarea[name=message]").val();
    var threadID = $("input[name=thread_id]").val();

    $.post("../api/forum/newReply.php", {message: message, thread_id: threadID}, function (data) {
        if (data.success) {
            resetForm($(".reply"));
            socket.emit("reply", {"thread_id": threadID});
        } else {
            console.log(data.error);
        }
    }, "json");
});

$(".threads").on("click", ".remove", function (e) {
    e.preventDefault();
    var container = $(this).parent().parent().parent().parent();
    var id = container.data('id');
    $.get("../api/forum/removePost.php", {id: id}, function (data) {
        if (data.error) {
            console.log(data.error);
        } else {
            socket.emit("remove", {thread_id: id});
            socket.emit("post", {"success": true});
        }
    }, "json");
});

$(".replies").on("click", ".remove", function (e) {
    e.preventDefault();
    var container = $(this).parent().parent().parent().parent();
    var id = container.data('id');
    $.get("../api/forum/removeReply.php", {id: id}, function (data) {
        if (data.error) {
            console.log(data.error);
        } else {
            console.log("removing thing");
            socket.emit("removePost", {thread_id: $("input[name=thread_id]").val()});
        }
    }, "json");
});

$(".solve").click(function (e) {
    e.preventDefault();
    var container = $(this).parent().parent().parent().parent();
    var id = container.data('id');
    $.get("../api/forum/solve.php", {id: id}, function (data) {
        if (data.error) {
            console.log(data.error);
        } else {
            socket.emit("post", {"success": true});
            window.location.reload();
        }
    }, "json");
});

$(".remove").click(function (e) {
    e.preventDefault();
    var container = $(this).parent().parent().parent().parent();
    var id = container.data('id');
    $.get("../api/forum/removePost.php", {id: id}, function (data) {
        if (data.error) {
            console.log(data.error);
        } else {
            socket.emit("remove", {thread_id: id});
            socket.emit("post", {"success": true});
        }
    }, "json");
});

$("#competitor_view").click(function (e) {
    e.preventDefault();
    $(this).addClass("disabled");

    $.get("../api/competitorView.php", {id: $(this).data("id")}, function (data) {
        $(".code-area").html(data);
        $(".code-display").modal();
        $("#competitor_view").removeClass("disabled");
    }, "html");
});