$(function () {
   if ($("input[name=id]")) {
       $.get("../../api/admin/newQuiz.php?id="+$("input[name=id]").val(), function (data) {
           console.log(data);
           if (data.error) {
               console.log(data.error);
           } else {
               $("input[name=quiz_name]").val(data['quiz_name']);
           }
       }, "json");
   }
});

$(".create").submit(function (e) {
    e.preventDefault();

    var postObj = {};
    $(this).find("input, textarea").each(function () {
        if ($(this).attr('name') === "problem_description") {
            postObj[$(this).attr('name')] = tinyMCE.get('problem_description').getContent();
        } else {
            postObj[$(this).attr("name")] = $(this).val();
        }
    });
    postObj.type = "create_edu_problem";
    $(".create").hide("fast");
    $(".alert-danger").hide("fast");
    $(".alert-info").show("fast");
    $(".alert-success").hide("fast");
    console.log(postObj);
    $.post("../../api/admin/newQuiz.php", postObj, function (e) {
        console.log(e);
        $(".alert-info").hide();
        if (e.error) {
            $(".alert-danger").text(e.error).show("slow");
            $(".create").show("fast");
        } else if (e.success) {
            $(".alert-success").text(e.success).show("fast");
            setTimeout(function () {
                window.location = "quizList.php";
            }, 1000);
        }
    }, "json");
});