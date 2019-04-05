<?
require_once "../content/require.php";

if (isset($_SESSION['competition_site_id'])) {
    header("Location: ../index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ProgrammingCompetition.org Competition Site - Log In</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script src="http://ws.programmingcompetition.org:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? include_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>

                    <div class="col-md-4">
                        <p class="lead text-center">
                            Log in to the competition site <b>using the login credentials given to you in your
                                competition folder.</b> If you are not able to log in for some reason, first try logging
                            in again, and if that doesn't work, please ask a volunteer for assistance.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <h3 class="text-center">Log in to your Competition Site Account</h3>

                        <form name="form" id="form" class="form-horizontal login-form">
                            <div class="alert alert-danger" style="display: none;">

                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="username" type="text" class="form-control" name="username" value=""
                                       placeholder="Username">
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password"
                                       placeholder="Password">
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right">Log in <i
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
</div>
<script>
    var redirect = "<? echo $_SERVER['HTTP_REFERER']; ?>";
</script>
<script src="../js/login.js"></script>
<script src="../js/liveEvents.js"></script>
</body>
</html>
