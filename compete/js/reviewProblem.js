/**
 * Created by Jacob on 3/14/16.
 */
var bar = $(".hover-top");
var topBar;
var barWidth;


$("#competitor_view").click(function (e) {
    e.preventDefault();
    $(this).addClass("disabled");

    $.get("../api/admin/competitorView.php", {id: $(this).data("id"), password: $(this).data("password")}, function (data) {
        $(".code-area").html(data);
        $(".code-display").modal();
        $("#competitor_view").removeClass("disabled");
    }, "html");
});

$(function () {

});

