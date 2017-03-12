$(function () {
   if ($("input[name=id]")) {
       $.get("../../api/admin/newProblem.php?id="+$("input[name=id]").val(), function (data) {
           console.log(data);
           if (data.error) {
               console.log(data.error);
           } else {
               tinyMCE.get('problem_description').setContent(data['problem_description']);
               $("input[name=problem_name]").val(data['problem_title']);
               $("textarea[name=problem_sample_input]").val(data['problem_sample_input']);
               $("textarea[name=problem_sample_output]").val(data['problem_sample_output']);
               $("textarea[name=problem_input]").val(data['problem_input']);
               $("textarea[name=problem_output]").val(data['problem_output']);
               $("textarea[name=code]").val(data['problem_code']);

           }
       }, "json");
   }
});

$(".create").submit(function (e) {
    e.preventDefault();

    if (!$("input[name=checkboxes]").is(':checked')) {
        $("input[name=checkboxes]").focus().parent().parent().addClass("has-error");
        return;
    }

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
    $.post("../../api/admin/newProblem.php", postObj, function (e) {
        console.log(e);
        $(".alert-info").hide();
        if (e.error) {
            $(".alert-danger").text(e.error).show("slow");
            $(".create").show("fast");
        } else if (e.success) {
            $(".alert-success").text(e.success).show("fast");
            setTimeout(function () {
                window.location = "problemList.php";
            }, 1000);
        }
    }, "json");
});