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
    <link href="/jb.css" rel="stylesheet">

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
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img src="http://programmingcompetition.org/images/SunNFPC.png" style="width: 175px;">
            </div>
            <div class="col-md-10 col-sm-10">
                <h1 class="text-center">Welcome to the fourth annual Naples Florida Programming
                    Competition, <? echo $teamName; ?>!</h1>
            </div>
        </div>
        <h3 class="text-center">Team Members</h3>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <p class="lead text-center"><strong><?
                        if (count($members) >= 1) {
                            echo ucfirst($members[0]['f_name']) . " " . ucfirst($members[0]['l_name']);
                        }
                        ?></strong></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <p class="lead text-center "><strong><?
                        if (count($members) >= 2) {
                            echo ucfirst($members[1]['f_name']) . " " . ucfirst($members[1]['l_name']);
                        }
                        ?></strong></p>
            </div>
        </div>
        <p class="lead text-justify">Welcome to the competition. Please do not loose this sheet of paper. If you do,
            please talk to any volunteer. Below are important credentials for logging in to the competition
            back-end.</p>
        <ul class="lead">
            <li>URL: http://programmingcompetition.org/compete</li>
            <li>Username: <? echo $teamUsername; ?></li>
            <li>Password: <? echo $teamPassword; ?></li>
        </ul>
        <p class="lead text-justify">Remember, there are no materials allowed in the competition room except for you and
            your brain! You must not discuss the problems with other teams during each round of the programming
            competition. Do not attempt to break any systems in place to prevent cheating. Any team found breaking these
            rules may be disqualified from the competition.<br><br>The competition is automatically scored. You will
            receive all input to your files through the standard input. The team with the lowest total score at the end
            of the competition will win. If you would like to dispute a question, please use the disputes button on the
            website. No questions about problems will be answered in the competition. Thank you for coming, and we are excited for a great day!</p>
        <span style="page-break-after: always;"></span>
    <?
    }

    ?>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
