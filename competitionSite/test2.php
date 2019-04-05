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
        <h1>USER LOGINS</h1>
    </div>
    <span style="page-break-after: always;"></span>
    <table class="table table-bordered table-striped">

    </table>
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
    <table class="table table-bordered table-striped">
        <tr>
            <th>Team Name</th>
            <th>Member 1</th>
            <th>Email</th>
            <th><span class="glyphicon glyphicon-tag"></span></th>
            <th>Member 2</th>
            <th>Email</th>
            <th><span class="glyphicon glyphicon-tag"></span></th>
            <th>Username</th>
            <th>Password</th>
        </tr>
        <tr>
            <td><? echo $teamName; ?></td>
            <td><?
                if (count($members) >= 1) {
                    echo ucfirst($members[0]['f_name']) . " " . ucfirst($members[0]['l_name']);
                }
                ?></td>
            <td><? if (count($members) >= 1) {
                    echo $members[0]['email'];
                } ?></td>
            <td><? if (count($members) >= 1) {
                    echo $members[0]['shirt_size'];
                } ?></td>
            <td><?
                if (count($members) >= 2) {
                    echo ucfirst($members[1]['f_name']) . " " . ucfirst($members[1]['l_name']);
                }
                ?></td>
            <td><? if (count($members) >= 2) {
                    echo $members[1]['email'];
                } ?></td>
            <td><? if (count($members) >= 2) {
                    echo $members[1]['shirt_size'];
                } ?></td>
            <td><? echo $teamUsername; ?></td>
            <td><? echo $teamPassword; ?></td>
        </tr>

        <tr>
            <th>Schools:</th>
            <td colspan="3"><? if (count($members) >= 1) {
                    echo $members[0]['school'];
                } ?></td>
            <td colspan="3"><? if (count($members) >= 2) {
                    echo $members[1]['school'];
                } ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <?
    }

    ?>

</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
