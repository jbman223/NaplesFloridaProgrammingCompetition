/**
 * Created by Jacob on 3/3/16.
 */

$("#compile_code").click(function (e) {
    e.preventDefault();
    var probId = $(this).data("id");
    $(this).parent().html("<img src='https://churchpop.com/wp-content/themes/Newspaper/images/AjaxLoader.gif' style='max-height:60px;' />");

    $.post("../../api/admin/runProblemCode.php", {id: probId}, function (data) {
        console.log(data);
        window.location.reload();
    }, "json");
});

$(".review-request").submit(function (e) {
    e.preventDefault();

    $.post("../../api/admin/addReviewer.php", {problem_id: $("input[name=problem_id]").val(), type: $("input[name=review]").val(), email: $("input[name=email]").val()}, function (data) {
        if (data.success) {
            window.location.reload();
        }
    }, "json");
});

$("#competitor_view").click(function (e) {
    e.preventDefault();
    $(this).addClass("disabled");

    $.get("../../api/admin/competitorView.php", {id: $(this).data("id")}, function (data) {
        $(".code-area").html(data);
        $(".code-display").modal();
        $("#competitor_view").removeClass("disabled");
    }, "html");
});