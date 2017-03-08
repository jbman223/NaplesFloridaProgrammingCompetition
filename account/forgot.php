<?
require_once "../includes/require.php";
require_once "../api/mailAPI.php";

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    die();
}

if (isset($_POST['email'])) {
    $state = $db->prepare("select * from users where email = ?");
    $state->execute(array($_POST['email']));

    $users = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {

        if ($users[0]["password_reset"] == 0) {
            $user_id = $users[0]['id'];
            $tempPassword = generatePassword();

            $state = $db->prepare("update users set password_reset = 1, temporary_password = ?, password_reset_time = ? where id = ?  ");
            $state->execute(array(md5($tempPassword), time(), $user_id));

            sendResetEamil($_POST['email'], $tempPassword);

            die(json_encode(array("success" => "You have been sent an email containing instructions to reset your password.")));
        } else {
            if (time() - $users[0]["password_reset_time"] >= 60*20) {
                $user_id = $users[0]['id'];
                $tempPassword = generatePassword();

                $state = $db->prepare("update users set password_reset = 1, temporary_password = ?, password_reset_time = ? where id = ?  ");
                $state->execute(array(md5($tempPassword), time(), $user_id));

                sendResetEamil($_POST['email'], $tempPassword);

                die(json_encode(array("success" => "You have been sent an email containing instructions to reset your password.")));
            } else {
                die(json_encode(array("error" => "You must wait another ".round((60*20 - (time() - $users[0]["password_reset_time"])) / 60)." minutes before you can reset your password again! Please check your email and spam folder for your link.")));
            }
        }
    } else {
        die(json_encode(array("error" => "Could not start password reset process.")));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Forgot Password</title>


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script async src="../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? include_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">
                <h3 class="text-center">Forgot Your Password</h3>
                <form name="form" id="form" class="form-horizontal login-form">
                    <div class="alert alert-danger" style="display: none;"></div>
                    <div class="alert alert-success" style="display: none;"></div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="text" class="form-control" name="email" value="" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right">Recover Password <i
                                    class="glyphicon glyphicon-log-in"></i>
                            </button>
                        </div>
                    </div>

                    <a href="register.php" class="text-center small">Create a new account &gt;</a> <br />
                    <a href="login.php" class="text-center small">Sign In &gt;</a>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(".form-horizontal").submit(function (e) {
        e.preventDefault();
        var email = $("input[id=email]").val();
        $(".alert").hide();

        $.post("forgot.php", {email: email}, function (data) {
            if (data.error) {
                $(".alert-danger").text(data.error).show("slow");
            } else {
                $(".alert-danger").hide();
                $(".alert-success").text(data.success).show();
                $(".submit-button").attr("disabled", "true");
                return false;
            }
        }, "json");
    });
</script>
</body>
</html>