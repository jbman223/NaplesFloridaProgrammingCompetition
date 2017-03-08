<?php
require_once "../../includes/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account.php");
    die();
}

if (isset($_GET['id'])) {
    $competitorID = $_GET['id'];
    $state = $db->prepare("SELECT team_id, COUNT(*) FROM competitors WHERE id = ?");
    $state->execute(array($competitorID));
    $ret = $state->fetchAll();
    $number = $ret[0]['COUNT(*)'];

    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($ret[0]['team_id'], $_SESSION['id'], 0));
    $isOwner = $state->fetchAll()[0][0] == 1;

    if ($number != 1 || !$isOwner) {
        die(json_encode(array("error" => "That competitor does not exist.")));
    }
}

if (isset($_POST['csrf'], $_POST['id']) && $csrf->validateCSRF("delete", $_POST['csrf'])) {
    $competitorID = $_POST['id'];
    $state = $db->prepare("SELECT team_id, COUNT(*) FROM competitors WHERE id = ?");
    $state->execute(array($competitorID));
    $ret = $state->fetchAll();
    $competitors = $ret[0]['COUNT(*)'];

    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($ret[0]['team_id'], $_SESSION['id'], 0));
    $number = $state->fetchAll()[0][0];
    if ($number == 1) {
        $state = $db->prepare("UPDATE competitors SET deleted = ? WHERE id = ?");
        $state->execute(array(1, $_POST['id']));
        die(json_encode(array("success" => "Your team has been deleted!")));
    } else {
        die(json_encode(array("error" => "You cannot delete that team.")));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Delete Member</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="starter-template">
                    <div class="content">
                        <h1>Delete Team Member</h1>

                        <p class="lead text-center">Are you sure you would like to delete this member? You can not undo this
                            action.</p>

                        <div class="text-center">
                            <? echo $csrf->outputCSRFForForm("delete"); ?>
                            <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">
                            <button type="button" class="btn btn-danger logout">Delete Member</button>
                            <button type="button" class="btn btn-default cancel">Cancel</button>
                        </div>
                    </div>
                    <div class="alerts" style="display: none;">
                        <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
                        <div class="alert alert-info text-center" role="alert" style="display: none;">Deleting,
                            please wait a second.
                        </div>
                        <div class="alert alert-success text-center" role="alert" style="display: none;">You have deleted this member.
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <script type="text/javascript">
        $(".logout").click(function () {
            $(".content").slideUp();
            $(".alerts").show();
            $.post("deleteMember.php", {csrf: $("input[name=csrf]").val(), id: $("input[name=id]").val()},function (data) {
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
            }, "json");
        });
        $(".cancel").click(function () {
            window.location = "<? echo $_SERVER['HTTP_REFERER'] ?>";
        });
    </script>
</body>
</html>