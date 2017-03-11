/**
 * Created by Jacob on 2/17/16.
 */
$(".form-horizontal").submit(function (e) {
    e.preventDefault();
    var username = $("input[id=username]").val();
    var password = $("input[id=password]").val();
    $(".alert").hide();

    console.log("starting");
    console.log(username);
    console.log(password);

    $.post("../api/login.php", {username: username, password: password}, function (data) {
        if (data.error) {
            $(".alert-danger").text(data.error).show("slow");
        } else {
            $(".alert-danger").text(data.error).hide();
            if (redirect)
                window.location = redirect;
            else
                window.location = "../index.php";
        }
    }, "json");
});