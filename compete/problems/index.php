<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

$state = $db->prepare("select * from competition_sections where start <= ? and `end` >= ?");
$state->execute(array(time(), time()));
$sections = $state->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Problem List</title>


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
                        <h1 class="text-center">Problem Listing</h1>
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
                                    $state = $db->prepare("select pd.problem_title, pd.id from competition_section_problems csp inner join problem_data pd on pd.id = csp.problem_id where csp.section_id = ? and csp.removed = 0");
                                    foreach ($sections as $section) {

                                        ?>
                                        <div role="tabpanel" class="tab-pane<? echo ($first)?" active":""; ?>" id="section<? echo $section['id']; ?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Problem Name</th>
                                                    <th>View Description</th>
                                                    <th>Submit Solution</th>
                                                    <th>Solved</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?
                                                $state->execute(array($section['id']));
                                                $problems = $state->fetchAll(PDO::FETCH_ASSOC);
                                                $state2 = $db->prepare("select * from solved_problems where problem_id = ? and team_id = ? and section_id = ? and correct = true");
                                                foreach ($problems as $problem) {

                                                    $state2->execute(array($problem['id'], $user['id'], $section['id']));
                                                    $correct = $state2->fetchAll(PDO::FETCH_ASSOC);

                                                    if (count($correct) > 0) {
                                                        $correct = true;
                                                    } else {
                                                        $correct = false;
                                                    }

                                                    ?>
                                                    <tr>
                                                        <td><? echo $problem['problem_title'] ?></td>
                                                        <td><a href="#" class="competitor-view" data-id="<? echo $problem['id']; ?>">View Description</a></td>
                                                        <td><a href="../solve" class="btn btn-default btn-sm">Submit Solution</a></td>
                                                        <td><? echo $correct?"<span class=\"glyphicon glyphicon-ok\"></span>":"<span class=\"glyphicon glyphicon-remove\"></span>"; ?></td>
                                                    </tr>
                                                    <?
                                                }
                                                ?>
                                                </tbody>
                                            </table>
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
                            <h2>There are no ongoing competitions to list a problem for.</h2>
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


    <script src="../js/solve.js"></script>
    <script src="../js/liveEvents.js"></script>
</body>
</html>