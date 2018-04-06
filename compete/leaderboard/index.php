<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

$state = $db->prepare("select * from competition_sections where start <= ? and `end` >= ? and removed = 0");
$state->execute(array(time(), time()));
$sections = $state->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Leaderboard</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>


    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Leader Board</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <?
                        if (count($sections) > 0) {
                            ?>
                            <div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <?
                                    $first = true;

                                    foreach ($sections as $section) {

                                        ?>
                                        <li role="presentation" <? echo ($first)?"class=\"active\"":""; ?>><a href="#section<? echo $section['id']; ?>" aria-controls="home" role="tab"
                                                                                                              data-toggle="tab"><? echo $section['section_name']; ?></a></li>
                                        <?
                                        $first = false;
                                    }
                                    $first = true;

                                    ?>
                                </ul>

                                <div class="tab-content">
                                    <?
                                    $first = true;
                                    foreach ($sections as $section) {

                                        ?>
                                        <div role="tabpanel" class="tab-pane<? echo ($first)?" active":""; ?> leaderboard" id="section<? echo $section['id']; ?>" data-sectionid="<? echo $section['id']; ?>">
                                        </div>
                                        <?
                                        $first = false;
                                    }
                                    ?>
                                </div>
                            </div>
                            <?
                        } else {
                            ?>
                            <h2>There are no ongoing competitions to list a leader board for.</h2>
                            <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade code-display" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body code-area">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <? require_once "../content/footer.php"; ?>
    <script src="../js/leaderboard.js"></script>
    <script src="../js/liveEvents.js"></script>
</body>
</html>