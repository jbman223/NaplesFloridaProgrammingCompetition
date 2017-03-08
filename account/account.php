<?php
require_once "../includes/require.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Account</title>


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-sm-4">

                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h3 class="text-center">Your Teams</h3>
                    </div>
                    <div class="col-lg-4 text-center col-sm-4">
                        <a href="teams/registerTeam.php" class="btn btn-success">Create Team</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?
                        if (count($teams) > 0) {
                            ?>
                            <table class="table table-bordered table-hover">
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
                                        <td><a href="teams/teamInfo.php?id=<? echo $team['id']; ?>"><? echo $team['team_name']; ?></a></td>
                                        <td><? echo $confirmedAmt; ?></td>
                                        <td><? echo $pendingAmt; ?></td>
                                        <td><a href="teams/registerTeamMember.php?id=<? echo $team['id']; ?>" class="btn btn-info">Add Member</a></td>
                                        <td><a href="teams/delete.php?id=<? echo $team['id']; ?>" class="btn btn-info">Delete Team</a></td>
                                    </tr>
                                <? } ?>
                            </table>
                            <?
                        } else {
                            ?>
                            <p class="text-center lead">No teams found for your account.
                                <br />
                                <a href="teams/registerTeam.php" class="btn btn-success btn-lg">Create Team</a></p>
                            <?
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>
