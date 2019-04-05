<?php
require_once "assets/require.php";
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

    <title>Register Team - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
    <? echo $gaCode; ?>
</head>

<body>
<div class="container">
    <div>
        <h1>TEAM LABELS</h1>
    </div>
    <span style="page-break-after: always;"></span>
    <?php
    $state = $db->prepare("SELECT * FROM teams WHERE admin = 0 AND deleted = 0");
    $state->execute();
    $teams = $state->fetchAll();

    $state = $db->prepare("SELECT * FROM competitors WHERE team_id = ?");
    $i = 1;
    foreach ($teams as $team) {
        $state->execute(array($team['id']));
        $members = $state->fetchAll();
        $teamName = $team['team_name'];
        $teamUsername = $team['backendLogin'];
        $teamPassword = $team['backendPassword'];
        ?>
        <div class="row" style="margin-top: 5in;transform: rotate(180deg);">
            <div class="col-md-2 col-sm-2">
                <img src="http://programmingcompetition.org/images/SunNFPC.png" style="width: 100%;">
            </div>
            <div class="col-md-10 col-sm-10">
                <h1 style="font-size: 100px;" class="text-center"><? echo $teamName; ?></h1>
            </div>
        </div>
        <span style="page-break-after: always;"></span>
        <?
    }

    ?>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(".register").submit(function (e) {
        e.preventDefault();
        $(".register").slideUp();
        $(".alert-info").show();
        var name = $("input[name=teamname]").val();

        $.post("registerAPI.php", {name: name, type: "register_team", csrf: $("input[name=csrf]").val()},function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-info").hide();
                $(".register").slideDown();
                $(".alert-danger").text(data.error).show();
            } else {
                $(".alert-info").hide();
                $(".alert-success").show();
                setTimeout(function () {
                    window.location = "account.php";
                }, 300);
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            alert(xhr.responseText);
            alert(textStatus);
            alert(errorThrown);
        })
    })
</script>
</body>
</html>
