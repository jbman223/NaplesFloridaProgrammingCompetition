<?php
require_once "../../../includes/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../index.php");
    die();
}

$state = $db->prepare("SELECT * FROM users where id = ?");
$state->execute(array($_SESSION['id']));
$user = $state->fetchAll(PDO::FETCH_ASSOC)[0];

if ($user['level'] < 1) {
    header("Location: ../index.php");
    die();
}

if (isset($_POST['id'], $_POST['password'], $_POST['password_confirm'])) {
    if ($_POST['password'] != $_POST['password_confirm']) {
        die(json_encode(array("error" => "The passwords you entered did not match.")));
    }

    $state = $db->prepare("select * from users where id = ?");
    $state->execute(array($_POST['id']));

    $users = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        $state = $db->prepare("update users set password = ?, password_reset = 0 where id = ?");
        $state->execute(array(password_hash($_POST['password'], PASSWORD_DEFAULT), $users[0]['id']));
        die(json_encode(array("success" => "Password reset.")));
    } else {
        die(json_encode(array("error" => "There was an error completing your request.")));
    }
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Reset User Password</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="/account/admin">Administration</a></li>
                            <li><a href="/account/admin/users">User Administration</a></li>
                            <li class="active">Reset Password</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Reset Password</h3>

                        <form name="form" id="form" class="form-horizontal login-form">
                            <div class="alert alert-danger" style="display: none;"></div>
                            <div class="alert alert-success" style="display: none;"></div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" value=""
                                       placeholder="Password">
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password_confirm" type="password" class="form-control" name="password_confirm"
                                       value="" placeholder="Confirm Password">
                            </div>
                            <input type="hidden" value="<? echo $_GET['id']; ?>" name="id" />
                            <div class="form-group">
                                <!-- Button -->
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right">Reset Password <i
                                            class="glyphicon glyphicon-log-in"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


    </div>


    <script>
        $(".form-horizontal").submit(function (e) {
            e.preventDefault();
            var passwordConfirm = $("input[id=password_confirm]").val();
            var password = $("input[id=password]").val();
            var code = $("input[name=id]").val();
            $(".alert").hide();

            $.post("newPassword.php", {id: code, password_confirm: passwordConfirm, password: password}, function (data) {
                if (data.error) {
                    $(".alert-danger").text(data.error).show("slow");
                } else {
                    $(".alert-danger").hide();
                    $(".alert-success").text("Your password has been reset successfully.").show();
                    window.location.href = "index.php";
                }
            }, "json");
        });
    </script>
</body>
</html>