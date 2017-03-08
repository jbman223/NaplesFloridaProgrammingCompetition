<?
require_once "../includes/require.php";

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    die();
}

if (isset($_POST['email'], $_POST['password'])) {
    $state = $db->prepare("select * from users where email = ?");
    $state->execute(array($_POST['email']));

    $users = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0 && password_verify($_POST['password'], $users[0]['password'])) {
        if ($users[0]['verified'] == 0) {
            die(json_encode(array("error" => "Please check your email for the verification link!")));
        }

        if ($users[0]['password_reset'] == 1) {
            $state = $db->prepare("update users set password_reset = 0 where id = ?");
            $state->execute(array($users[0]['id']));
        }

        $_SESSION['id'] = $users[0]['id'];
        die(json_encode(array("success" => "The user has logged in successfully.")));
    } else {
        die(json_encode(array("error" => "The user was not found.")));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Log In</title>


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
                <h3 class="text-center">Log In</h3>

                <form name="form" id="form" class="form-horizontal login-form">
                    <?

                    if (isset($_SESSION["result"])) {
                        if (isset($_SESSION['result']['error'])) {
                            ?>
                            <div class="alert alert-danger">
                                <? echo $_SESSION['result']['error']; ?>
                            </div>
                            <?
                        } else {
                            ?>
                            <div class="alert alert-success">
                                <? echo $_SESSION['result']['success']; ?>
                            </div>
                            <div class="alert alert-danger" style="display: none;"></div>
                            <?
                        }

                        unset($_SESSION['result']);
                    } else {
                        ?>
                        <div class="alert alert-danger" style="display: none;"></div>
                        <?
                    } ?>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="text" class="form-control" name="email" value="" placeholder="Email">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-md-8 col-sm-12 controls">
                            <a href="register.php" class="pull-left small">Create An Account</a><br>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right">Log in <i
                                    class="glyphicon glyphicon-log-in"></i>
                            </button>
                        </div>
                    </div>

                    <a href="forgot.php" class="text-center small">Forgot your password?</a>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(".form-horizontal").submit(function (e) {
        e.preventDefault();
        var email = $("input[id=email]").val();
        var password = $("input[id=password]").val();
        $(".alert").hide();

        console.log("starting");

        $.post("login.php", {email: email, password: password}, function (data) {
            if (data.error) {
                $(".alert-danger").text(data.error).show("slow");
            } else {
                $(".alert-danger").text(data.error).hide();
                window.location.href = "<? echo (isset($_GET['redirect'])?$_GET['redirect']:"account.php"); ?>";
                return false;
            }
        }, "json");
    });
</script>
</body>
</html>
