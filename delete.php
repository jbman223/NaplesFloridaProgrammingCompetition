<?php
require_once "includes/require.php";
if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

if (isset($_GET['id'])) {
    $teamID = $_GET['id'];
    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($teamID, $_SESSION['id'], 0));
    $number = $state->fetchAll()[0][0];

    if ($number != 1) {
        die(json_encode(array("error" => "You cannot delete that team.")));
    }
}

if (isset($_POST['csrf'], $_POST['id']) && $csrf->validateCSRF("delete", $_POST['csrf'])) {
    $teamID = $_POST['id'];
    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($_POST['id'], $_SESSION['id'], 0));
    $number = $state->fetchAll()[0][0];
    if ($number == 1) {
        $state = $db->prepare("UPDATE teams SET deleted = ? WHERE id = ? AND owner_id = ?");
        $state->execute(array(1, $_POST['id'], $_SESSION['id']));
        die(json_encode(array("success" => "Your team has been deleted!")));
    } else {
        die(json_encode(array("error" => "You cannot delete that team.")));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Naples Florida Programming Competition.">
    <meta name="author" content="Jacob Buckheit">
    <link rel="icon" href="../../favicon.ico">

    <title>Delete Team - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
    <? echo $gaCode; ?>
</head>

<body>

<? include_once "includes/menu.php"; ?>

<div class="container">

    <div class="starter-template">
        <div class="content">
            <h1>Delete Team</h1>

            <p class="lead text-center">Are you sure you would like to delete this team? You can not undo this
                action.</p>

            <div class="text-center">
                <? echo $csrf->outputCSRFForForm("delete"); ?>
                <input type="hidden" name="id" value="<? echo $teamID; ?>">
                <button type="button" class="btn btn-danger logout">Delete Team</button>
                <button type="button" class="btn btn-default cancel">Cancel</button>
            </div>
        </div>
        <div class="alerts" style="display: none;">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Registering your account,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">You have deleted your team.
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(".logout").click(function () {
        $(".content").slideUp();
        $(".alerts").show();
        $.post("delete.php", {csrf: $("input[name=csrf]").val(), id: $("input[name=id]").val()},function (data) {
            console.log(data);
            $(".alert-success").show();
            if (data.success) {
                setTimeout(function () {
                    window.location = "<? echo $_SERVER['HTTP_REFERER'] ?>";
                }, 450);
            }

            if (data.error) {
                $(".alert-danger").text(data.error).show();

            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            alert(xhr.responseText);
            alert(textStatus);
            alert(errorThrown);
        });
    });
    $(".cancel").click(function () {
        window.location = "<? echo $_SERVER['HTTP_REFERER'] ?>";
    });
</script>
</body>
</html>
