<?php
require_once "includes/require.php";
if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

$state = $db->prepare("SELECT * FROM `teams` WHERE `owner_id` = ? AND deleted = 0");
$state->execute(array($_SESSION['id']));
$teams = $state->fetchAll(PDO::FETCH_ASSOC);
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

    <title>Account - Naples Florida Programming Competition</title>

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
        <h1>Account</h1>

        <p class="lead text-center">Create and manage your teams.</p>
    </div>

    <div class="row">
        <div class="col-lg-4 col-sm-4">

        </div>
        <div class="col-lg-4 col-sm-4">
            <h3 class="text-center">Your Teams</h3>
        </div>
        <div class="col-lg-4 text-center col-sm-4">
            <a href="registerTeam.php" class="btn btn-success">Create Team</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?
            if (count($teams) > 0) {
                ?>
                <table class="table table-hover">
                    <tr>
                        <th>Team Name</th>
                        <th># Members</th>
                        <th>Pending Members</th>
                        <th>Add Member</th>
                        <th>Delete Team</th>
                    </tr>
                    <? foreach ($teams as $team) {
                        $state = $db->prepare("SELECT COUNT(*) FROM `competitors` WHERE `verified` = 0 AND team_id = ? AND deleted = 0");
                        $state->execute(array($team['id']));
                        $pendingAmt = $state->fetchAll()[0][0];
                        $state = $db->prepare("SELECT COUNT(*) FROM `competitors` WHERE `verified` = 1 AND team_id = ? AND deleted = 0");
                        $state->execute(array($team['id']));
                        $confirmedAmt = $state->fetchAll()[0][0];
                        ?>

                    <tr>
                        <td><a href="teamInfo.php?id=<? echo $team['id']; ?>"><? echo $team['team_name']; ?></a></td>
                        <td><? echo $confirmedAmt; ?></td>
                        <td><? echo $pendingAmt; ?></td>
                        <td><a href="registerTeamMember.php?id=<? echo $team['id']; ?>" class="btn btn-info">Add Member</a></td>
                        <td><a href="delete.php?id=<? echo $team['id']; ?>" class="btn btn-info">Delete Team</a></td>
                    </tr>
                    <? } ?>
                </table>
            <?
            } else {
                ?>
                <p class="text-center lead">No teams found for your account. Try adding one above.</p>
            <?
            }
            ?>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
