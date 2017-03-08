<?
require_once "../includes/require.php";
require_once "../api/mailAPI.php";
require_once "../api/SendyPHP.php";

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    die();
}

if (isset($_POST['email'], $_POST['password'], $_POST['passwordConfirm'], $_POST['username'])) {
    if ($_POST['password'] != $_POST['passwordConfirm']) {
        die(json_encode(array("error" => "The passwords did not match.")));
    }

    if (strlen($_POST['password']) <= 6) {
        die(json_encode(array("error" => "Your password is too short. Passwords must be at least 7 characters.")));
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die(json_encode(array("error" => "You must enter a valid email.")));
    }

    $state = $db->prepare("select * from users where email = ?");
    $state->execute(array($_POST['email']));

    $users = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        die(json_encode(array("error" => "There is already a user registered with that email address.")));
    } else {
        $verifyCode = generatePassword();
        $state = $db->prepare("insert into users (email, username, password, verification_code, verification_email_time) values (?, ?, ?, ?, ?)");
        $state->execute(array($_POST['email'], $_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT), md5($verifyCode), time()));

        sendVerifyEmail($_POST['email'], $verifyCode);

        $sendy = new \SendyPHP\SendyPHP(array(
            'api_key' => 'w9IyE3iSADjBhVvtUPBf', //your API key is available in Settings
            'installation_url' => 'http://mail.minecraftnoobtest.com',  //Your Sendy installation
            'list_id' => 'MzOmp2grUlMlSi4Mq9w9Eg'
        ));

        $sendy->subscribe(array(
            'name'=>$_POST['username'],
            'email' => $_POST['email']
        ));



        die(json_encode(array("success" => "Your account has been created successfully. Please check your email ")));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Register</title>


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">

    <script async src="/AuditClick/AuditClick.js"></script>

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
                <div class="row">
                    <div class="col-md-7 col-sm-6 hidden-xs">
                        <h3 class="text-center">Why sign up for an account?</h3>
                        <ol>
                            <li>It takes less than a minute.</li>
                            <li>Access the ProgrammingCompetition.org Education Center.</li>
                            <li>Create teams to compete in the competition.</li>
                            <li>Get notified of competition news and events.</li>
                        </ol>
                    </div>
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <h3 class="text-center">Register</h3>
                        <div class="alert alert-danger" style="display: none;"></div>

                        <form name="form" id="form" class="form-horizontal login-form">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="email" type="text" class="form-control" name="email" value="<? echo (isset($_GET['e']) && filter_var($_GET['e'], FILTER_VALIDATE_EMAIL))?$_GET['e']:""; ?>"
                                       placeholder="Email">
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="username" type="text" class="form-control" name="username" value=""
                                       placeholder="Name">
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password"
                                       placeholder="Password">
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password-confirm"
                                       placeholder="Confirm Password">
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-sm-12 controls">

                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right"><i
                                            class="glyphicon glyphicon-log-in"></i> Register
                                    </button>
                                </div>
                            </div>

                            <a href="login.php" class="text-center small">Already have an account? Sign in &gt;</a>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(".form-horizontal").submit(function (e) {
        e.preventDefault();
        var email = $("input[id=email]").val();
        var password = $("input[id=password]").val();
        var passwordConfirm = $("input[id=password-confirm]").val();
        var username = $("input[id=username]").val();
        $(".alert").hide();

        if (password != passwordConfirm) {
            $(".alert").text("The password and password confirmation must match.").show("slow");
            return;
        }

        $.post("register.php", {
            email: email,
            password: password,
            passwordConfirm: passwordConfirm,
            username: username
        }, function (data) {
            if (data.error) {
                $(".alert").text(data.error).show("slow");
            } else {
                $(".alert").hide().removeClass("alert-danger").addClass("alert-success").text("Please check your email to verify your account.").show();
                $(".form-horizontal").hide();
                //window.location.href = "login.php";
                return false;
            }
        }, "json");
    });
</script>
</body>
</html>
