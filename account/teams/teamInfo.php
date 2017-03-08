<?php
require_once "../../includes/require.php";
if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

$state = $db->prepare("SELECT * FROM `teams` WHERE `owner_id` = ? AND id = ? AND deleted = 0");
$state->execute(array($_SESSION['id'], $_GET['id']));
$teams = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($teams) == 0) {
    header("Location: account.php");
    die();
}

$state = $db->prepare("SELECT * FROM `competitors` WHERE team_id = ? AND deleted = 0");
$state->execute(array($teams[0]['id']));
$competitors = $state->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Team Info</title>


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

                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="../account.php">Account</a></li>
                            <li class="active"><? echo $teams[0]['team_name']; ?></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-4">

                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h3 class="text-center"><? echo $teams[0]['team_name']; ?></h3>
                    </div>
                    <div class="col-lg-4 text-center col-sm-4">
                        <a href="registerTeamMember.php?id=<? echo $teams[0]['id']; ?>" class="btn btn-success">Add Member</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?
                        if (count($competitors) > 0) {
                            ?>
                            <table class="table table-hover">
                                <tr>
                                    <th>Member Name</th>
                                    <th>Verified</th>
                                    <!--                        <th>Edit Information</th>-->
                                    <th>Delete Member</th>
                                </tr>
                                <? foreach ($competitors as $competitor) { ?>
                                    <tr>
                                        <td><? echo $competitor['f_name']." ".$competitor['l_name']; ?></td>
                                        <? if ($competitor['verified'] == 1) { ?>
                                            <td><span class="glyphicon glyphicon-ok"></span></td>
                                        <? } else { ?>
                                            <td><span class="glyphicon glyphicon-remove"></span></td>
                                        <? } ?>
                                        <!--                            <td><a href="editTeamMember.php?id=--><?// echo $competitor['id']; ?><!--" class="btn btn-info">Edit Member</a></td>-->
                                        <td><a href="deleteMember.php?id=<? echo $competitor['id']; ?>" class="btn btn-info">Delete Member</a></td>
                                    </tr>
                                <? } ?>
                            </table>
                            <?
                        } else {
                            ?>
                            <p class="text-center lead">No members found for this team. Try adding one above.</p>
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
