<?php
require_once "../../content/require.php";

if (!isset($_GET['id'])) {
    header("location: index.php");
    die();
}

$state = $db->prepare("select * from competitions where id = ?");
$state->execute(array($_GET['id']));

$competition = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($competition) == 0) {
    header("Location: index.php");
    die();
}
$competition = $competition[0];

$state = $db->prepare("select * from competition_sections where competition_id = ? and removed = false and start <= ? and `end` >= ?");
$state->execute(array($competition['id'], time(), time()));

$competitionSections = $state->fetchAll(PDO::FETCH_ASSOC);

$currentSection = $competitionSections[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Live Screen</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>
    <input type="hidden" name="section_id" value="<? echo $currentSection['id']; ?>" />

    <div class="container-fluid" style="color:white;">
        <div class="row">
            <div class="col-md-12 text-center">
                <p style="font-size: 52px;font-weight: bold;text-shadow: 1px 1px 3px rgba(0,0,0,0.5);"><? echo $competition['competition_name']; ?></p>

                <p class="small" style="font-weight: bold;text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">TOP 5 THIS SECTION</p>


                <div class="leaderboard">

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="taunt-box row">

        </div>
    </div>


    <div class="footer" style="position: fixed;bottom:0;left:0;color: white;width:100%;height:70px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center"><span class="competition-name">Hello World</span> | <span class="section-name-footer">Warm Up Round</span> - <span class="time-remaining" data-secondsremaining="1543" style="font-weight: bold;">13:44:37</span> Remaining</h1>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/liveScreen.js"></script>
    <script src="../../js/liveEvents.js"></script>
</body>
</html>