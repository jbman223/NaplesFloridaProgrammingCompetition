$(function () {
   if ($("input[name=competition_id]")) {
       $.get("../../api/admin/newCompetition.php?id="+$("input[name=competition_id]").val(), function (data) {
           console.log(data);
           if (data.error) {
               console.log(data.error);
           } else {
               $("input[name=competition_name]").val(data['competition_name']);
               $("textarea[name=competition_description]").val(data['competition_notes']);


           }
       }, "json");
   }
});

$(".create").submit(function (e) {
    e.preventDefault();
    var postObj = {};
    $(this).find("input, textarea").each(function () {
            postObj[$(this).attr("name")] = $(this).val();
    });
    postObj.type = "create_edu_problem";
    $(".create").hide("fast");
    $(".alert-danger").hide("fast");
    $(".alert-info").show("fast");
    $(".alert-success").hide("fast");
    console.log(postObj);
    $.post("../../api/admin/newCompetition.php", postObj, function (e) {
        console.log(e);
        $(".alert-info").hide();
        if (e.error) {
            $(".alert-danger").text(e.error).show("slow");
            $(".create").show("fast");
        } else if (e.success) {
            $(".alert-success").text(e.success).show("fast");
            setTimeout(function () {
                window.location = "competitionList.php";
            }, 0);
        }
    }, "json");
});